<?php
class SearchController extends Controller
{
public function __construct()
{
	parent::__construct();
	loadHelper('zipsearch');
	
}

public function indexAction()
{
	if(isset($_GET['input']))
	{
			$input = $_GET['input'];	
	}
	if(isset($_GET['value']))
	{
		$value = $_GET['value'];
	}
	if(isset($input)  || isset($value))
	{

		$data['search']=$this->csearchconsumers(); 
	}
	$data['canadian']=$this->distinctcountryname();
	$this->view->render('search/search.phtml', $data);
			

}


//////////////////////////////////////////////////////////////////////
public function csearchconsumers()
{
			$value = $_GET['value'];
			if(isset($_POST['searchZip']))
			{
				$searchZip = trim($_POST['searchZip']);
				$requestZipCode = $_POST['requestZipCode'];				
				if(!is_numeric($requestZipCode)) $requestZipCode = substr(str_replace(" ", "", $requestZipCode), 0, 5);
				//echo "***********$requestZipCode**************";
				loadHelper('url');
				redirect('search/?input=consumers&&value=findStore&&gzipcode='.$requestZipCode.'');
			}	

			if($value == 'findStore') 
			{ 
				$data['csearch']=$this->cwhereAction();
				return $data['csearch'];
			}
			else{ echo'bye'; die();include ("$pgms/consumer/consumermain.php");}	
			}		

public function cwhereAction()
{
		if(isset($_GET['gzipcode']))	{ 	$gzipcode = $_GET['gzipcode'];	}
		if(isset($_GET['gstate']))		{ 	$gstate = $_GET['gstate']; 		}		
		if(isset($_GET['gcity']))		{ 	$gcity = $_GET['gcity'];		}
		if(isset($_GET['gcountry']))	{ 	$gcountry = $_GET['gcountry']; 	}
		if (isset($value) && isset($user)) 
		{
			if($value == 'edit' && $user == '101')
				{
					include("$path/admin/processMember.php");
				}
		}		
		else if(isset($gzipcode)) { $cwhere=$this->clistforzipAction($gzipcode); return $cwhere; }
		else if(isset($gstate))   { $cwhere=$this->storebyregions($gstate); return $cwhere;  }//include ("$pgms/consumer/listforState.php"); // YO chae pachi tyo "Find 1559 Stores by Regions"  wala
		else include ("$pgms/consumer/listforCountry.php"); // yo chae http://192.168.1.7/hdc_old/?input=consumers ko lagi AND  esma "else include ("$pgms/consumer/consumermain.php");"-> INDEX.PHP(pgms/consumer/index.php) ko
}


public function clistforzipAction($gzipcode)
{
	$model = getModel('search');
	$zipCityval = $model->zipCity($gzipcode);
	$data['clistfor']=		"<strong style=\"font-size: 14px; color: #0066cc;\">";
	$data['clistfor'].= 	"Nearest Stores from  ".$zipCityval." $gzipcode";
	$data['clistfor'].= 	"</strong>"; 
    $data['clistfor'].=		"<hr align=\"left\" style=\"background-color: #0066cc; width:100%; \" >";
	$data['clistfor'].= 	"If first time, please call the store(s) for availability before visiting them. Thank you.";
	$data['clistfor'].= 	"<p>";
	$sql=$model->allretailzip();	 
	$l=$model->findLatlon(substr($gzipcode, 0,5)); 
	$lat_1_rad= $l['latitude'];	 
	$lon_1_rad= $l['longitude'];
	$distance = array();	
	$nrsid = "";
	foreach ($sql as $row) {
				$rsid = $row['rsid'];
		$lat2 = $row['latitude'];
		$lon2 = $row['longitude'];
		
		$getDistance = round(distance($lat_1_rad, $lon_1_rad, $lat2, $lon2, "m"), 2);
		
		if(is_nan($getDistance)) $getDistance = 0;
		
		if($rsid != $nrsid || ($rsid == $nrsid && $getDistance < $distance[$row['rsid']]))
			$distance[$row['rsid']] = $getDistance;
		
		$nrsid = $rsid;
	}	
	asort($distance); 
	$cnt = 1;
	$rowcnt = 1;
	$data['clistfor'].=	 "<table cellspacing='15' cellpadding='0' align='center' valign='middle' width='100%' style=\"background-color: ;\">";
	foreach ($distance as $key => $val) {		
	//$dquery = "SELECT * FROM retstores, retailers WHERE retstores.rsid = '$key' AND retstores.rid = retailers.rid";
		$members=$model->restoreretailers($key);		 
		$rid = $members[0]['rid'];
		$name = $members[0]['rsnm'];
		$add = $members[0]['rsadd'];
		$add2 = $members[0]['rsadd2'];
		$city = $members[0]['rscity'];
		$state = $members[0]['rsstate'];
		$zip = zipForm($members[0]['rszip'], $state);
		$tel = $members[0]['rstel'];
		$rsdes = $members[0]['rsdes'];
		$website = $members[0]['rwebsite'];
		$data['clistfor'].= "<tr>";
		$data['clistfor'].= "<td class='productInfo2' width='100%' valign='middle' style=\"padding: 20px 20px 20px 20px;\">";

				//if($user == "101") echo "<br>$dquery<br>";

				$data['clistfor'].= "<strong style=\"font-size: 12px; ;\">$name</strong>";

				$data['clistfor'].= " &raquo; ";

				$data['clistfor'].= ptelForm($tel);

				

				$data['clistfor'].= "<br>";

				$data['clistfor'].= "<hr align='left'>";

				if($rsdes == "Online Sales Only") echo "$rsdes";

				else {
					if($add) $data['clistfor'].= "$add, ";
	
					if($add2) $data['clistfor'].= "Ste $add2, ";
	
					$data['clistfor'].= "$city, $state $zip";
				
		

					$wadd = str_replace(" ", "+", $add);
	
			
	
					$data['clistfor'].= "<br>&raquo; <a href='http://maps.google.com/maps?q=$wadd+$city+$state+$zip' target='map'  >map</a>";
	
					$data['clistfor'].= " | $val miles";
				}
				
				//$usertyperid=$model->userType($rid);
				//var_dump($usertyperid);
				$usertyperid=$model->userType($rid); /// same as userType($rid)
				if($website && $usertyperid == "retailer") $data['clistfor'].= " &raquo; <a href='http://$website' target='new' >$website</a>";

				

				if(isset($user) && ($user == '101')) {$data['clistfor'].= "<br><a href='?input=admin&&view=retailers&&process=edit&&qual=$rid'>E</a>";}

				

		$data['clistfor'].= "</td>";

		$data['clistfor'].= "</tr>";



		

		if($cnt == 25) break;

		else $cnt ++;

	}
	return $data['clistfor'];

}


public function distinctcountryname()
{
			$discountyval= 			"<div class=\"productInfo2\" style=\"padding: 20px 20px 20px 20px;\">";
			$discountyval.= 		"<strong>Find ";
			$model = getModel('search');
			$discountyval.= 		$model->totalSellers();
			$discountyval.= 		" Stores by Regions</strong>";	
			$sql=$model->distinctcounty();
			foreach ($sql as $sql)
			 {
				$country=$sql['country'];
				$statesql=$model->state_query($country);
				$discountyval.= 	"<select name=\"country_$country\" onChange=\"javascript: location.href = this.options[this.selectedIndex].value\" style=\" width: 250px; padding: 3px 3px 3px 3px; margin: 10px 0px 0px 0px; \" >";
				$discountyval.= 	"<option value=''>";
				$discountyval.= 	"Find in ";
				$discountyval.= 	$model->getCountry($country);
				$discountyval.= 	"</option>";
				foreach ($statesql as $statesql)
				 {
					$state_abb = $statesql['rsstate'];

					$state_name = $statesql['stt_nm'];
					$discountyval.= "<option value='".URL."search/?input=consumers&&value=findStore&&gstate=$state_abb'>$state_name</option>";
					
				}
				$discountyval.= 	"</select>";
			}	
						

			$discountyval.= 		"</div>";

				

			$discountyval.= 		"<br>";

			// nt in database--------------------------------------------------------------------------------------alina

			//if there is a request for list for state

			//find the cities

			if(isset($gstate))
			{

				$city_query = "SELECT DISTINCT retstores.rscity, retstores.rshdc, retstores.rsstate FROM retstores WHERE rshdc = '1' AND rsstate = '$gstate' GROUP BY retstores.rscity ORDER BY retstores.rscity ASC";

				
				//if($user == '101') echo "<br> *** $city_query *** <br>";
				

				$discountyval.= 	"<div class=\"productInfo2\" style=\"padding: 20px 20px 20px 20px;\">";

				$discountyval.= 	"<strong>Cities in ";

				$discountyval.= 	getState($gstate) . " : " . totalSellersState($gstate) . " Stores";

				$discountyval.= 	"</strong>";

				$discountyval.= 	"<hr align=\"left\" />";

				

				$citysql = mysql_query($city_query);

				

				while ($cities = mysql_fetch_array($citysql))
				{

					$cityName = $cities['rscity'];

					

					$discountyval.= "&raquo; <a href=\"$url/?input=consumers&&value=findStore&&gstate=$gstate&&gcity=$cityName\">$cityName</a><br>";

				}

				

				//echo "<br>";

				$discountyval.= 	"</div>";		

			}

		return $discountyval;	

        	
}



public function storebyregions($gstate)
{
	$model = getModel('search');
	$storebyregionsval= 		"<strong style=\"font-size: 14px; color: #0066cc;\">";
	$storebyregionsval.= 		"Listing Stores in ";
	if(isset($gcity) )echo "$gcity, ";
	$storebyregionsval.=		 $model->getState($gstate);
	$storebyregionsval.=		 "</strong>";

	$storebyregionsval.=		 "<hr align=\"left\" style=\"background-color: #0066cc; width:100%; \" >";
	$storebyregionsval.=		 "If first time, please call the store(s) for availability before visiting them. Thank you.";
	$storebyregionsval.=		 "<p>";
	if(isset($gcity))
	{
		$cquery=$model->searchbycountystatecity($gcity,$gstate);
	}
	else
	{
		$cquery=$model->searchbycountystate($gstate);
	}
	$storebyregionsval.=		 "<table cellspacing='15' cellpadding='0' align='center' valign='middle' width='100%' style=\"background-color: ;\">";
	$cnt = 1;
	$rowcnt = 1;
	foreach ($cquery as $stores) 
	{
		$mid = $stores['mid'];
		$name = $stores['rsnm'];
		$add = $stores['rsadd'];
		$add2 = $stores['rsadd2'];
		$city = $stores['rscity'];
		$state = $stores['rsstate'];
		$zip = $stores['rszip'];
		$tel = $stores ['rstel'];
		$des = $stores ['rsdes'];
		$website = $stores['rwebsite'];
		$rsdes = $stores['rsdes'];
		$storebyregionsval.=		 "<tr>";
		$storebyregionsval.=		 "<td class='productInfo2' width='100%' valign='middle' style=\"padding: 20px 20px 20px 20px;\">";
		$storebyregionsval.=		 "<strong style=\"font-size: 12px; ;\">$name</strong>";
		$storebyregionsval.=		 " &raquo; ";		
		$storebyregionsval.=		 $this->ptelForm($tel);
		$storebyregionsval.=		 "<br>";
		$storebyregionsval.=		 "<hr align='left'>";
		if(!empty($rsdes) == "Online Sales Only"){ $storebyregionsval.= "$rsdes"; } 
		else
		{ 
			if(!empty($add)) $storebyregionsval.=  						"$add, ";
			if(!empty($add2)) $storebyregionsval.= 						"Ste $add2, ";
			$storebyregionsval.=										"$city, $state $zip";
			if(!empty($add))
			{ 
				$wadd = str_replace(" ", "+", $add);
				$storebyregionsval.=									"<br>&raquo; <a href='http://maps.google.com/maps?q=$wadd+$city+$state+$zip' target='map'  >map</a>";	
			}
		}	
		$usertyperid=$model->userType($mid);
		if($website && $usertyperid == "retailer") {$storebyregionsval.= " &raquo; <a href='http://$website' target='new' >$website</a>";}
		if(isset($user))
		{	
			if($user == '101') $storebyregionsval.=						 "<br><a href='?input=admin&&view=retailers&&process=edit&&qual=$mid'>E</a>";
		}
		$storebyregionsval.=		 "</td>";
		$storebyregionsval.=		 "</tr>";
	}
	$storebyregionsval.=			 "</table>";
	return $storebyregionsval;
}





public function ptelForm($tel)
{
	$a = substr($tel, 0,3);
	if(strlen($tel) > 6){
		$b = substr($tel, 3,3);
		$c = substr($tel, 6);
		return "($a) $b-$c";
	}
	else
	{
		$b = substr($tel, 3);
		return "$a-$b";
	}

}
//////////////////////////////////////////////////////////////////////









}