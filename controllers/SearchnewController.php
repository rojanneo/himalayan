<?php
class SearchnewController extends Controller
{
public function __construct()
{
	parent::__construct();
	loadHelper('zipsearch');
	
}

public function indexAction()
{
	$data=array();
	if(isset($_POST['searchZip']))
	{
		
	$searchZitestp = trim($_POST['searchZip']);
	$data['submitval']=$_POST['requestZipCode'];
	}
	if(isset($_GET['q']))
	{
		
	$data['submitval']=$_GET['q'];
	}
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

		//$data['search']=$this->csearchconsumers(); 
		$data['search']=$this->csearchconsumersnew();
	}
	else
	{
		$data['search']=$this->consumermain();
	}
	//$data['canadian']=$this->distinctcountryname();
	$this->view->render('searchnew/search.phtml', $data);
			

}



//new function
public function csearchconsumersnew()
{
	if(isset($_POST['searchZip']))
	{
		$searchZitestp = trim($_POST['searchZip']);
		$requestZipCode = $_POST['requestZipCode'];	
		if(!isset($_GET['gstate']))
		{
			$gstatesval=getModel('searchnew')->srchsGstateNgcity($requestZipCode);
			if($gstatesval)
			{ 
				loadHelper('url');
				redirect($gstatesval);
			}
			if(!is_numeric($requestZipCode)) $requestZipCode = substr(str_replace(" ", "", $requestZipCode), 0, 5);	
			else
			{ 
						//echo "***********$requestZipCode**************";
			loadHelper('url');
			redirect('searchnew/?input=consumers&&value=findStore&&gzipcode='.$requestZipCode.'&&q='.$requestZipCode.'');
			}
				
		}
	}


	if(isset($_GET['gzipcode']) || isset($_GET['gstate']) || isset($_GET['gcity'])) 
	{ 
		$data['csearch']=$this->cwhereActionnew();
		return $data['csearch'];
	}
	else
	{ 
		$data['consumer']=$this->consumermain();
		return $data['consumer'];	
	}



}


public function cwhereActionnew()
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
		else if(isset($gstate))   { $cwhere=$this->storebyregionsnew($gstate); return $cwhere;  }//include ("$pgms/consumer/listforState.php"); // YO chae pachi tyo "Find 1559 Stores by Regions"  wala
		else include ("$pgms/consumer/listforCountry.php"); // yo chae http://192.168.1.7/hdc_old/?input=consumers ko lagi AND  esma "else include ("$pgms/consumer/consumermain.php");"-> INDEX.PHP(pgms/consumer/index.php) ko
}

public function storebyregionsnew($gstate)
{
	$find_us_default_line2 = getModel('configuration')->getConfigValue('find_us_default_line2');
	if(isset($_GET['gcity']))		{ 	$gcity = $_GET['gcity'];		}
	if(isset($_GET['gstore']))		{ 	$gstore = $_GET['gstore'];		}
	$model = getModel('searchnew');
	$storebyregionsval= 		"<div class='search-title'><strong>";
	$storebyregionsval.= 		"stores near  ";
	$storebyregionsval.=		 $model->getState($gstate);
	$storebyregionsval.=		 "</strong>";

	$storebyregionsval.=		 "<p>".$find_us_default_line2."</p></div>";
	if(isset($gcity))
	{
		if(isset($gstore))
		{
		$cquery=$model->searchbycountystatecitystore($gcity,$gstate,$gstore);	
		}
		else
		{
		$cquery=$model->searchbycountystatecity($gcity,$gstate);
		}
		//var_dump($cquery); die();		
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
		$storebyregionsval.=		 "<td class='productInfo2' width='100%' valign='middle' style=\"padding: 10px 20px 10px 20px;\">";
		$storebyregionsval.=		 "<strong style=\"font-size: 12px; ;\">$name</strong>";
		$storebyregionsval.=		 "<p>&nbsp;&gt;&gt; ".$this->ptelForm($tel)."</p>";
		$storebyregionsval.=		 "<br><span>";
		if(!empty($rsdes) == "Online Sales Only"){ $storebyregionsval.= "$rsdes"; } 
		else
		{ 
			if(!empty($add)) $storebyregionsval.=  						"$add, ";
			if(!empty($add2)) $storebyregionsval.= 						"Ste $add2, ";
			$storebyregionsval.=										"$city, $state $zip";
			if(!empty($add))
			{ 
				$wadd = str_replace(" ", "+", $add);
				$storebyregionsval.=									"<br>&nbsp;&gt;&gt; <a href='http://maps.google.com/maps?q=$wadd+$city+$state+$zip' target='map'  >map</a>";	
			}
		}	
		$usertyperid=$model->userType($mid);
		if($website && $usertyperid == "retailer") {$storebyregionsval.= " &nbsp;| <a href='http://$website' target='new' >$website</a>";}
		if(isset($user))
		{	
			if($user == '101') $storebyregionsval.=						 "<br><a href='?input=admin&&view=retailers&&process=edit&&qual=$mid'>E</a>";
		}
		$storebyregionsval.=		 "</span></td>";
		$storebyregionsval.=		 "</tr>";
	}
	$storebyregionsval.=			 "</table>";
	return $storebyregionsval;
}


//new function end


//////////////////////////////////////////////////////////////////////
public function csearchconsumers()
{
			//$value = $_GET['value'];

			if(isset($_POST['searchZip']))
			{
				
				$searchZitestp = trim($_POST['searchZip']);
				$requestZipCode = $_POST['requestZipCode'];	

				if(!isset($_GET['gstate']) )
				{
						$gstatesval=getModel('searchnew')->searchgstate($requestZipCode);
						if($gstatesval)
						{	

						loadHelper('url');
						//$_GET['gstate']=$gstatesval[0]['abb'];
						// /var_dump($_GET['gstate']); die();
						redirect('searchnew/?input=consumers&&value=findStore&&gstate='.$gstatesval.'');
						}
				}
				if(!isset($_GET['gcity']) || !isset($_GET['gstate']))
				{

					
						$gcityval=getModel('searchnew')->searchgcity($requestZipCode); // eha changes garnnu cha 
						if($gcityval ){ loadHelper('url'); redirect('searchnew/?input=consumers&&value=findStore&&gstate='.$gcityval[0]['rsstate'].'&&gcity='.$requestZipCode.''); }
				}	

				

				if(!is_numeric($requestZipCode)) $requestZipCode = substr(str_replace(" ", "", $requestZipCode), 0, 5);	
				else
				{ 
						//echo "***********$requestZipCode**************";
				loadHelper('url');
				redirect('searchnew/?input=consumers&&value=findStore&&gzipcode='.$requestZipCode.'');
				}
			}	
			
			if(isset($_GET['value']) && $_GET['value'] == 'findStore') 
			{ 
				//var_dump($_GET['gcity']); 
				//var_dump($_GET['gstate']); die();
				$data['csearch']=$this->cwhereAction();
				return $data['csearch'];
			}
			else
			{ 
				$data['consumer']=$this->consumermain();
				return $data['consumer'];	
			}
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
	$find_us_default_line2 = getModel('configuration')->getConfigValue('find_us_default_line2');
	$model = getModel('searchnew');
	$zipCityval = $model->zipCity($gzipcode);
	$data['clistfor']=		"<div class='search-title'><strong>";
	$data['clistfor'].= 	"stores near  ".$zipCityval." $gzipcode";
	$data['clistfor'].= 	"</strong>"; 
	$data['clistfor'].= 	"<p>".$find_us_default_line2."</p></div>";
	
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
		$data['clistfor'].= "<td class='productInfo2' width='100%' valign='middle' style=\"padding: 10px 20px 10px 20px;\">";

				//if($user == "101") echo "<br>$dquery<br>";

				$data['clistfor'].= "<strong style=\"font-size: 12px; ;\">$name</strong>";

				$data['clistfor'].= "<p>&nbsp;&gt;&gt; ".$this->ptelForm($tel)."</p>";

				

				$data['clistfor'].= "<br><span>";


				if($rsdes == "Online Sales Only") echo "$rsdes";

				else {
					if($add) $data['clistfor'].= "$add, ";
	
					if($add2) $data['clistfor'].= "Ste $add2, ";
	
					$data['clistfor'].= "$city, $state $zip";
				
		

					$wadd = str_replace(" ", "+", $add);
	
			
	
					$data['clistfor'].= "<br>&nbsp;&gt;&gt; <a href='http://maps.google.com/maps?q=$wadd+$city+$state+$zip' target='map'  >map</a>";
	
					$data['clistfor'].= " | $val miles";
				}
				
				//$usertyperid=$model->userType($rid);
				//var_dump($usertyperid);
				$usertyperid=$model->userType($rid); /// same as userType($rid)
				if($website && $usertyperid == "retailer") $data['clistfor'].= " | <a href='http://$website' target='new' >$website</a>";

				

				if(isset($user) && ($user == '101')) {$data['clistfor'].= "<br><a href='?input=admin&&view=retailers&&process=edit&&qual=$rid'>E</a>";}

				

		$data['clistfor'].= "</span></td>";

		$data['clistfor'].= "</tr>";



		

		if($cnt == 25) break;

		else $cnt ++;

	}
	$data['clistfor'].="</table>";
	return $data['clistfor'];

}


public function distinctcountryname()
{
			if(isset($_GET['gstate']))		{ 	$gstate = $_GET['gstate']; 		}
			$discountyval= 			"<div class=\"productInfo2\" style=\"padding: 10px 20px 10px 20px;\">";
			$discountyval.= 		"<strong>Find ";
			$model = getModel('searchnew');
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
					$discountyval.= "<option value='".URL."searchnew/?input=consumers&&value=findStore&&gstate=$state_abb'>$state_name</option>";
					
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
				$discountyval.= 	"<div class=\"productInfo2\" style=\"padding: 10px 20px 10px 20px;\">";

				$discountyval.= 	"<strong>Cities in ";

				$discountyval.= 	$model->getState($gstate) . " : " . $model->totalSellersState($gstate) . " Stores";

				$discountyval.= 	"</strong>";

				$cities=$model->city_query($gstate);
				foreach ($cities as $cities) 
				{
					$cityName = $cities['rscity'];
					$discountyval.= "&nbsp;&gt;&gt; <a href=\"?input=consumers&&value=findStore&&gstate=$gstate&&gcity=$cityName\">$cityName</a><br>";
				}
				$discountyval.= 	"</div>";		

			}

		return $discountyval;	

        	
}



public function storebyregions($gstate)
{
	$find_us_default_line2 = getModel('configuration')->getConfigValue('find_us_default_line2');
	if(isset($_GET['gcity']))		{ 	$gcity = $_GET['gcity'];		}
	$model = getModel('searchnew');
	$storebyregionsval= 		"<div class='search-title'><strong>";
	$storebyregionsval.= 		"stores near  ";
	$storebyregionsval.=		 $model->getState($gstate);
	$storebyregionsval.=		 "</strong>";

	$storebyregionsval.=		 "<p>".$find_us_default_line2."</p></div>";
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
		$storebyregionsval.=		 "<td class='productInfo2' width='100%' valign='middle' style=\"padding: 10px 20px 10px 20px;\">";
		$storebyregionsval.=		 "<strong style=\"font-size: 12px; ;\">$name</strong>";
		$storebyregionsval.=		 "<p>&nbsp;&gt;&gt; ".$this->ptelForm($tel)."</p>";
		$storebyregionsval.=		 "<br><span>";
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
				$storebyregionsval.=									"<br>&nbsp;&gt;&gt; <a href='http://maps.google.com/maps?q=$wadd+$city+$state+$zip' target='map'  >map</a>";	
			}
		}	
		$usertyperid=$model->userType($mid);
		if($website && $usertyperid == "retailer") {$storebyregionsval.= " | <a href='http://$website' target='new' >$website</a>";}
		if(isset($user))
		{	
			if($user == '101') $storebyregionsval.=						 "<br><a href='?input=admin&&view=retailers&&process=edit&&qual=$mid'>E</a>";
		}
		$storebyregionsval.=		 "</span></td>";
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

public function consumermain()
{
	$find_us_default_line1 = getModel('configuration')->getConfigValue('find_us_default_line1');
	$find_us_default_line2 = getModel('configuration')->getConfigValue('find_us_default_line2');
	$consumermain='<div class="search-title"><strong style=\"font-size: 14px; color: #0066cc;\">'.$find_us_default_line1.'<br></strong><p>'.$find_us_default_line2.'</p></div>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
					 <tr>
						<td valign="top"  colspan="2" > 
        					<div class="productInfoM1">
        					<div class="productInfoM2" >        
								<!--<strong style="font-size: 14px; color: #0066cc;">Consumer Information</strong>
        						<hr align="left" style="background-color: #0066cc; width:100%; " /> <br /><br />-->
        			';
    $state_sql=getModel('searchnew')->state_query(null);
    $consumermain.="    <table cellspacing='5' cellpadding='0' align='center' valign='middle' width='100%'>";
    foreach ($state_sql as $statesql)
    {
    	$state = $statesql['stt_nm'];

		$st_abb = $statesql['rsstate'];

		$consumermain.="	<tr>
								<td class='productInfo21' width='100%' valign='middle' style=\"padding: 15px 15px 15px 20px;\">
									<strong \">".$state."</strong>
						";
		$city_sql=getModel('searchnew')->city_query($st_abb);

		$consumermain.="			<table cellspacing='0' cellpadding='3' align='center' valign='middle' width='100%' >
										<tr>";	
		$total_cities=$city_sql[0]['totalrowcount'];
		$cnt = 1;
		foreach ($city_sql as $city_sql)
		{
			$cityName = $city_sql['rscity'];
			$cityName = ucfirst(strtolower($cityName));
			$consumermain.="				<td><a href=\"".URL."searchnew/?input=consumers&&value=findStore&&gstate=$st_abb&&gcity=$cityName\">".$cityName."</a>
						   					</td>
						   ";
			if($cnt % 3 == 0 && $cnt != $total_cities) $consumermain.="
									  </tr>
													  <tr>";

			if($cnt == $total_cities) $consumermain.="</tr>";

			
			$cnt++;
		}

		$consumermain.="			</table>
								</td>
							</tr>
					   ";
	
    }
    $consumermain.=" </table>";						
   
    $consumermain.='		</div>
    						</div>
    					</td>
    				 </tr>
    				</table>'; 
      
	return $consumermain;
}
//////////////////////////////////////////////////////////////////////









}