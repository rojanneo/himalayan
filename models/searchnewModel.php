<?php

//require_once('system/model.php');
class SearchnewModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function zipCity($zip)
	{
		if(is_numeric ($zip))
		{
		$sqlsyn="SELECT * FROM zipcodes WHERE zipcode=$zip";
		$sql=$this->connection->Query($sqlsyn);
		$rowcount=$this->connection->GetRowCount($sqlsyn);		
		if($sql && $rowcount > 0)
		{

			return $sql[0]['city'].',&nbsp' .$sql[0]['state'];
		}
		}
		else return 0;		
	}

	public function allretailzip()
	{
		$sqlsyn="SELECT distinct retstores.rszip, retstores.rid, retailers.rid, retstores.rsid, retstores.rshdc, zipcodes.zipcode, zipcodes.latitude, zipcodes.longitude FROM retstores, retailers, zipcodes WHERE retstores.rid = retailers.rid AND retstores.rshdc = '1' AND (zipcodes.zipcode = retstores.rszip OR zipcodes.zipcode = substring(retstores.rszip, 1, char_length(retstores.rszip) - 1)) ORDER BY retstores.rsid";
		$sql=$this->connection->Query($sqlsyn);
		return $sql;
	}

	public function findLatlon($gzipcode)
	{
		if(is_numeric ($gzipcode))
		{
		$sqlsyn="SELECT * FROM zipcodes WHERE zipcode = $gzipcode";
		$sql=$this->connection->Query($sqlsyn);
		$rowcount=$this->connection->GetRowCount($sqlsyn);
		if($sql && $rowcount > 0)
		{
		$l['latitude'] = $sql[0]['latitude'];
		$l['longitude']=$sql[0]['longitude'];
		return $l;
		}
		}
		else return 0;
	}

	public function restoreretailers($key)
	{
		$sqlsyn="SELECT * FROM retstores, retailers WHERE retstores.rsid = '$key' AND retstores.rid = retailers.rid";
		$sql=$this->connection->Query($sqlsyn);
		return $sql;
	}
	public function userType($mid)
	{
		$sqlsyn="SELECT * FROM members WHERE mid = $mid";
		$sql=$this->connection->Query($sqlsyn); 
		if($sql)
		{
			$mtype = $sql[0]['mtype'];
			return $mtype;
		}	
		else return 0;
		
	}

	public function totalSellers()
	{
		$sqlsyn = "SELECT count(*) FROM retstores WHERE rshdc = '1'";
		$sql=$this->connection->Query($sqlsyn);
		return $sql[0]['count(*)'];
	}

	public function distinctcounty()
	{
		$sqlsyn = "SELECT DISTINCT country FROM members, retailers, retstores, state WHERE members.mid = retailers.rid AND retailers.rauth LIKE '%pur%' AND retstores.rshdc = '1' AND state.abb = members.mstate GROUP BY members.mstate ORDER BY state.country ASC";	
		$sql = $this->connection->Query($sqlsyn);
		return $sql;
	}
	public function state_query($country)
	{
		if(!isset($country))
		{
			$sqlsyn="SELECT DISTINCT retstores.rsstate, retstores.rshdc, state.stt_nm  FROM retstores, state WHERE retstores.rshdc = '1' AND state.abb = retstores.rsstate GROUP BY state.stt_nm ORDER BY state.stt_nm ASC";
		}
		else
		{
		$sqlsyn="SELECT DISTINCT retstores.rsstate, retstores.rshdc, state.stt_nm, state.country  FROM retstores, state WHERE state.country = '$country' AND retstores.rshdc = '1' AND state.abb = retstores.rsstate GROUP BY state.stt_nm ORDER BY state.country ASC, state.stt_nm ASC";
		}
		$sql=$this->connection->Query($sqlsyn);
		return $sql;
	}
	public function getCountry($countryCode)
	{
		$sqlsyn="SELECT * FROM countries WHERE countryCode = '$countryCode'";
		$sql=$this->connection->Query($sqlsyn);
		if(isset($sql))
		{
			return $sql[0]['countryName']; 
		}
		else
		{
			return 0;
		}

	}

	public function getState($stateCode)
	{

		$araystate = explode(",", $stateCode);
		$array = array();
		foreach ($araystate as $val) 
		{
			$value = "'".$val."'";
			array_push($array, $value);
		}
		$state = implode(',',$array);
		$sqlsyn = "SELECT * FROM state WHERE abb IN ($state)";
		$sql=$this->connection->Query($sqlsyn);
		if(isset($sql))
		{
		foreach ($sql as $sql) 
		{
				 if(isset($vall)){ $vall.=','.$sql['stt_nm']; } else{$vall=$sql['stt_nm'];} 
		}	
		return $vall;
		}
		else return 0;
	}

	public function searchbycountystatecitystore($gcity,$gstate,$gstore)
	{
		//for gstate
		$araystate = explode(",", $gstate);
		$array1 = array();
		foreach ($araystate as $val) 
		{
			$value = "'".$val."'";
			array_push($array1, $value);
		}
		$state = implode(',',$array1);

		//for gcity
		$araygcity = explode(",", $gcity);
		$array2 = array();
		foreach ($araygcity as $val2) 
		{
			$value2 = "'".$val2."'";
			array_push($array2, $value2);
		}
		$city = implode(',',$array2);
		//for gstore
		$araygstore = explode(",", $gstore);
		$array3 = array();
		foreach ($araygstore as $val3) 
		{
			$value3 = "'".$val3."'";
			array_push($array3, $value3);
		}
		$store = implode(',',$array3);

		
		$sqlsyn="SELECT * FROM members, retstores, retailers WHERE members.mid = retstores.rid AND (retstores.rscity IN($city) OR retstores.rsstate IN($state) OR retstores.rsnm IN($store))";
		$sqlsyn.=" AND members.mid = retailers.rid  AND retstores.rshdc = '1' ";
		$sqlsyn.="Group By members.mid ORDER BY retstores.rsnm ASC";
		$sql=$this->connection->Query($sqlsyn);

		return $sql;
	}

	public function searchbycountystatecity($gcity,$gstate)
	{
		//for gstate
		$araystate = explode(",", $gstate);
		$array1 = array();
		foreach ($araystate as $val) 
		{
			$value = "'".$val."'";
			array_push($array1, $value);
		}
		$state = implode(',',$array1);

		//for gcity
		$araygcity = explode(",", $gcity);
		$array2 = array();
		foreach ($araygcity as $val2) 
		{
			$value2 = "'".$val2."'";
			array_push($array2, $value2);
		}
		$city = implode(',',$array2);


		/*$sqlsyn="SELECT * FROM members, retstores, retailers WHERE members.mid = retstores.rid AND retstores.rscity LIKE \"%$gcity%\" AND retstores.rsstate like '$gstate'";
		$sqlsyn.=" AND members.mid = retailers.rid  AND retstores.rshdc = '1' ";
		$sqlsyn.=" ORDER BY retstores.rsnm ASC";
		*/
		$sqlsyn="SELECT * FROM members, retstores, retailers WHERE members.mid = retstores.rid AND (retstores.rscity IN($city) OR retstores.rsstate IN($state))";
		$sqlsyn.=" AND members.mid = retailers.rid  AND retstores.rshdc = '1' ";
		$sqlsyn.="Group By members.mid ORDER BY retstores.rsnm ASC";
		$sql=$this->connection->Query($sqlsyn);

		return $sql;
	}



	public function searchbycountystate($gstate)
	{
		$araystate = explode(",", $gstate);
		$array = array();
		foreach ($araystate as $val) 
		{
			$value = "'".$val."'";
			array_push($array, $value);
		}
		$state = implode(',',$array);		
		//$gstate="'AL', 'WA'";
		$sqlsyn="SELECT * FROM members, retstores, retailers WHERE members.mid = retstores.rid AND retstores.rsstate IN ($state)";
		$sqlsyn.= " AND members.mid = retailers.rid  AND retstores.rshdc = '1' ";
		$sqlsyn.=" ORDER BY retstores.rscity ASC, retstores.rsnm ASC";
		$sql=$this->connection->Query($sqlsyn);
		return $sql;
	}

	public function city_query($st_abb)
	{
		$sqlsyn="SELECT DISTINCT retstores.rscity, retstores.rshdc, retstores.rsstate FROM retstores WHERE rshdc = '1' AND rsstate = '".$st_abb."' GROUP BY retstores.rscity ORDER BY retstores.rscity ASC";
		$sql=$this->connection->Query($sqlsyn);
		$sql[0]['totalrowcount']=$this->connection->GetRowCount($sqlsyn);
		return $sql;
	}


	public function totalSellersState($gstate)
	{
		$query = "SELECT count(*) FROM retstores WHERE rshdc = '1' AND rsstate = '$gstate'";
		$sql=$this->connection->Query($query);
		return $sql[0]['count(*)'];
	}

	/// for new changes
	public function searchgstate($requestZipCode)
	{
		//$query="SELECT * FROM state WHERE stt_nm='$requestZipCode'";
		$sql = "SELECT abb,stt_nm FROM state WHERE stt_nm like '%$requestZipCode%' ";

		$abbval=$this->connection->Query($sql); 
		//var_dump($abbval); die();
		//var_dump($abbval); die();
		$val = null;
		if(isset($abbval))
		{
			foreach ($abbval as $abbval) 
			//if(isset($abbval[0]['abb']))
			{
				//$abb=$abbval[0]['abb']; 
				$abb=$abbval['abb'];
				$stt_nm=$abbval['stt_nm'];	
				$query="SELECT  DISTINCT retstores.rsstate, retstores.rshdc, state.stt_nm FROM members, retstores, retailers, state WHERE state.stt_nm='$stt_nm' AND retailers.rauth='pur'
				 AND members.mstate='".$abb."' AND members.mtype='retailer' AND retstores.rsstate='".$abb."' AND retstores.rshdc='1'";
				 $query1=$this->connection->Query($query);				
				if($query1){ if(isset($val)){ $val.=','.$query1[0]['rsstate']; } else{$val=$query1[0]['rsstate'];} }
			}
			return $val;
		}

		else
		{
			return false;//die('hye');
		}
		
	}

	public function searchgcity($requestZipCode)
	{
		//$sql = "SELECT * FROM members WHERE mcity='$requestZipCode' AND mtype = 'retailer'  ORDER BY mcity ASC";		
		//return $this->connection->Query($sql);
	//	$sql="SELECT DISTINCT retstores.rsstate, retstores.rshdc, retstores.rscity, retstores.rsnm FROM members, retstores, retailers WHERE retstores.rscity='$requestZipCode' AND retstores.rshdc='1'
	//			AND members.mcity='$requestZipCode' AND members.mtype='retailer' AND retailers.rauth='pur'"; 
		$sql="SELECT DISTINCT retstores.rsstate, retstores.rshdc, retstores.rscity, retstores.rsnm FROM members, retstores, retailers WHERE retstores.rscity='$requestZipCode' AND retstores.rshdc='1'
				AND members.mcity='$requestZipCode' AND retailers.rauth='pur'"; 
		$query=$this->connection->Query($sql);
	
		if(isset($query)) return $query;
		else return false;
	}




///////////////////////new search idea
	public function srchsGstateNgcity($requestZipCode)
	{
		$val 			=		(array) null;
		$state 			=		(array) null;
		$storestate 	=		(array) null;
		$state 			=		(array) null;
		//state variable initialized		
		$storecity 		=		(array) null;
		$city1			=		(array) null;
		$city 			=		(array) null;
		//city variable initialized
		$store 			=		null;
		$storestate 	=		(array) null;
		$storeval 		= 		null;
		//store vailable Initialized
		$result 		=		array();
		$stateval 		=		null;
		$cityval 		=		null;
		$sql = "SELECT abb,stt_nm FROM state WHERE stt_nm like '%$requestZipCode%' ";
		$abbval=$this->connection->Query($sql);	
		if($abbval)
		{		
		$array1 = array();
		$array2=array();
		foreach ($abbval as $abbvalin) 
		{
			$i=$abbvalin['stt_nm'];
			$j=$abbvalin['abb'];
			$value1 = "'".$i."'";
			$value2 = "'".$j."'";  
			array_push($array1, $value1);
			array_push($array2, $value2);
		}
		$stateStt_nm = implode(',',$array1);
		$stateAbb = implode(',',$array2);
		$queryIN="SELECT  GROUP_CONCAT(DISTINCT retstores.rsstate) FROM members, retstores, retailers, state WHERE state.stt_nm IN ($stateStt_nm) AND retailers.rauth='pur'
				 AND members.mstate IN ($stateAbb) AND members.mtype='retailer' AND retstores.rsstate IN ($stateAbb) AND retstores.rshdc='1'";
		$valqueryin=$this->connection->query($queryIN);
		$val=$valqueryin[0]['GROUP_CONCAT(DISTINCT retstores.rsstate)'];
		if(!empty($val)) { $val=explode(',',$val); }
		}
		/*if(isset($abbval))
		{
			foreach ($abbval as $abbval)
			{
				$abb=$abbval['abb'];
				$stt_nm=$abbval['stt_nm'];	
				$query="SELECT  DISTINCT retstores.rsstate, retstores.rshdc, state.stt_nm FROM members, retstores, retailers, state WHERE state.stt_nm='$stt_nm' AND retailers.rauth='pur'
				 AND members.mstate='".$abb."' AND members.mtype='retailer' AND retstores.rsstate='".$abb."' AND retstores.rshdc='1'";
				 $query1=$this->connection->Query($query);			
				if($query1){ if(isset($val)){ $val.=','.$query1[0]['rsstate']; } else{$val=$query1[0]['rsstate'];} }
			}
			$gstate=$val;
			var_dump($val); die();
		}
	*/

		//check if that name city also exst or not
		/*$citycheck="SELECT DISTINCT retstores.rsstate, retstores.rshdc, retstores.rscity, retstores.rsnm FROM members, retstores, retailers WHERE retstores.rscity LIKE'%$requestZipCode%'
					 AND retstores.rshdc='1' AND members.mcity like'%$requestZipCode%' AND retailers.rauth='pur'";
		*/		 
		$citycheck="SELECT GROUP_CONCAT(DISTINCT retstores.rsstate), GROUP_CONCAT(DISTINCT retstores.rscity) FROM members, retstores, retailers WHERE retstores.rscity LIKE'%$requestZipCode%'
					 AND retstores.rshdc='1' AND retailers.rid = retstores.rid AND members.mid = retstores.rid AND retailers.rauth='pur'";

		$cityquery=$this->connection->Query($citycheck);
		//var_dump($citycheck); die();
		$stateval=$cityquery[0]["GROUP_CONCAT(DISTINCT retstores.rsstate)"];
		$stateval=explode(',', $stateval);
		$cityval=$cityquery[0]["GROUP_CONCAT(DISTINCT retstores.rscity)"];	
		if(!empty($cityval)){ $city1=explode(',',$cityval); }

		/*
		$city=$cityquery[0]["GROUP_CONCAT(DISTINCT retstores.rscity)"];				
			if(!empty($val) && !empty($stateval))
			 {	$state	= array_unique (array_merge($val,$stateval)); 
			 	$state  = implode(',', $state);			 		
			 }
			if(!empty($val) && empty($stateval)) { $state=$val; 	  $state  = implode(',', $state);		 }
			if(!empty($stateval) && empty($val)) { $state=$stateval;  $state  = implode(',', $state);	    }
		*/

		//check if the store even exsit

		$storequery 				=	"SELECT  GROUP_CONCAT(DISTINCT retstores.rsstate), GROUP_CONCAT(DISTINCT retstores.rscity), GROUP_CONCAT(DISTINCT retstores.rsnm) FROM retstores,retailers,members WHERE retstores.rsnm LIKE '%$requestZipCode%' AND retstores.rid=retailers.rid AND retstores.rid=members.mid ";
		$storevalue 				= 	$this->connection->Query($storequery);
		$storestateval				=	$storevalue[0]['GROUP_CONCAT(DISTINCT retstores.rsstate)']; 
		$storecityval 				=	$storevalue[0]['GROUP_CONCAT(DISTINCT retstores.rscity)'];
		$storeval 					= 	$storevalue[0]['GROUP_CONCAT(DISTINCT retstores.rsnm)']; 
		if(!empty($storestateval))		{	$storestate=explode(',',$storestateval); } 
		if(!empty($storecityval))	{	$storecity=explode(',', $storecityval);		}
		

		//state final merged value
		$state 		=		array_unique(array_merge($val,$stateval,$storestate)); 
		if(isset($state)){ 	$state=implode(',', $state)	;				} 

		//city final merged value
		$city 		= 		array_unique(array_merge($city1,$storecity)); 
		if(isset($city))			{	$city=implode(',',$city);	}

		//store value
		if(!empty($storeval))	{	$store=$storeval;		}
		

		//if(!empty($store)) { echo'no empty'; var_dump($store); die(); } else{ var_dump($store); die(); }
		//if(!empty($city)){ var_dump($city); die();} else{ var_dump($city); echo'empty'; die();}
		//if(!empty($state)){ var_dump($state);  die(); } else{ var_dump($state); echo'empty'; die();}
		if(!empty($state) && !empty($city)  && !empty($store))
		 {
		 	$result	=	'searchnew/?input=consumers&&value=findStore&&gstate='.$state.'&&gcity='.$city.'&&gstore='.$store.'&&q='.$requestZipCode.'';
		 	return $result;
		 }

		
		 else if(!empty($state) && !empty($city) && empty($store))
		 {
		 	
		 	$result	=	'searchnew/?input=consumers&&value=findStore&&gstate='.$state.'&&gcity='.$city.'&&q='.$requestZipCode.'';
		 	return $result;
		 }

		 elseif (!empty($state) && empty($city))
		 {
		 	return'searchnew/?input=consumers&&value=findStore&&gstate='.$state.'&&q='.$requestZipCode.'';
		 }

		 else
		 {
		 	return false;
		 }

			
		/*

		 if(!empty($state) && !empty($city))
		 {
		 	$result	=	'searchnew/?input=consumers&&value=findStore&&gstate='.$state.'&&gcity='.$city.'';
		 	return $result;
		 }
		 elseif (!empty($state) && empty($city))
		 {
		 	return'searchnew/?input=consumers&&value=findStore&&gstate='.$state.'';
		 }
		 else
		 {
		 	return false;
		 }
		 */

	}


}