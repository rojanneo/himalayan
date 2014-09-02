<?php

//require_once('system/model.php');
class SearchModel extends Model
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
	$sqlsyn = "SELECT * FROM state WHERE abb = '$stateCode'";
	$sql=$this->connection->Query($sqlsyn);
		if(isset($sql))
		{
		return $sql[0]['stt_nm'];
		}
		else return 0;
	}

	public function searchbycountystatecity($gcity,$gstate)
	{
		$sqlsyn="SELECT * FROM members, retstores, retailers WHERE members.mid = retstores.rid AND retstores.rscity LIKE \"%$gcity%\" AND retstores.rsstate LIKE '$gstate'";
		$sqlsyn.=" AND members.mid = retailers.rid  AND retstores.rshdc = '1' ";
		$sqlsyn.=" ORDER BY retstores.rsnm ASC";
		$sql=$this->connection->Query($sqlsyn);
		return $sql;
	}

	public function searchbycountystate($gstate)
	{
		$sqlsyn="SELECT * FROM members, retstores, retailers WHERE members.mid = retstores.rid AND retstores.rsstate LIKE '$gstate'";
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


}