<?php

class StoreModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getStores($first=0, $limit=10,$retailer_id = false)
	{
		if($retailer_id != false)
		{
			$query = "SELECT * FROM `retstores` WHERE rid=".$retailer_id."  ORDER BY TRIM(rsnm) ASC LIMIT ".$first.",".$limit;
			$stores = $this->connection->Query($query);
			return $stores;
		}
		else
		{
			$query = "SELECT * FROM `retstores` ORDER BY TRIM(rsnm) ASC LIMIT ".$first.",".$limit;
			$stores = $this->connection->Query($query);
			return $stores;			
		}
	}

	public function getstorebyname($first=0, $limit=10,$storename,$count)
	{
		//var_dump($_POST['storename']); die();
		if($count != false)
		{
			$sql="SELECT COUNT(*) FROM retstores WHERE `rsnm` Like '%$storename%' ORDER BY `rsnm` ASC";
			$count=$this->connection->Query($sql);
			return $count[0]["COUNT(*)"];
		}
		else
		{
		$sql="SELECT * FROM `retstores` WHERE `rsnm` Like '%$storename%' ORDER BY `rsnm` ASC LIMIT ".$first.",".$limit;	
		//echo $sql;
		$query=$this->connection->Query($sql);
		if($query){return $query;}
		else return false;
		}
		
		
	}

	public function getStoreCount($retailer_id = false)
	{
		if($retailer_id != false)
		{
			$query = 'SELECT COUNT(*) FROM retstores WHERE rid='.$retailer_id;
			$count = $this->connection->Query($query);
			return $count;
		}
		else
		{
			$query = 'SELECT COUNT(*) FROM retstores';
			$count = $this->connection->Query($query);
			return $count[0]['COUNT(*)'];			
		}
	}

	public function deleteStore($store_id)
	{
		$query = "DELETE FROM retstores WHERE rsid = ".$store_id;
		return $this->connection->DeleteQuery($query);
	}

	public function saveStore($post_data)
	{
		if(isset($post_data)) extract($post_data);

		$sql = "SELECT * FROM retailers WHERE rid = $rid";
		$rshdc = 0;
		$retailer = $this->connection->Query($sql);
		if($retailer) $retailer = $retailer[0];
		if($retailer['rauth'] == 'pur') $rshdc = 1;

		$query = "INSERT INTO retstores SET 
		rid = '".mysql_real_escape_string($rid)."',
		rsnm = '".mysql_real_escape_string($rsnm)."',
		rshdc = '".mysql_real_escape_string($rshdc)."',
		rsadd = '".mysql_real_escape_string($rsadd)."',
		rsadd2 = '".mysql_real_escape_string($rsadd2)."',
		rscity = '".mysql_real_escape_string($rscity)."', 
		rsstate = '".mysql_real_escape_string($rsstate)."', 
		rszip = '".mysql_real_escape_string($rszip)."',
		rstelprivate = '".mysql_real_escape_string($rstelprivate)."',
	   	rstel = '".mysql_real_escape_string($rstel)."', 
	    	rsfax = '".mysql_real_escape_string($rsfax)."', 
	   	rswebsite = '".mysql_real_escape_string($rswebsite)."',
	    	rsemailprivate = '".mysql_real_escape_string($rsemailprivate)."',
	    	rsemail = '".mysql_real_escape_string($rsemail)."',
	    	rsdes = '".mysql_real_escape_string($rsdes)."'";

	   return $this->connection->InsertQuery($query);
	}

	public function updateStoreInfo($post_data)
	{
		if(isset($post_data)) extract($post_data);
$sql = "SELECT * FROM retailers WHERE rid = $rid";
		$rshdc = 0;
		$retailer = $this->connection->Query($sql);
		if($retailer) $retailer = $retailer[0];
		if($retailer['rauth'] == 'pur') $rshdc = 1;
		$query = "UPDATE `retstores` SET 
		`rid`='".mysql_real_escape_string($rid)."',
		`rshdc` = '".mysql_real_escape_string($rshdc)."',
		`rsnm`='".mysql_real_escape_string($rsnm)."',
		`rsadd`='".mysql_real_escape_string($rsadd)."',
		`rsadd2`='".mysql_real_escape_string($rsadd2)."',
		`rscity`='".mysql_real_escape_string($rscity)."',
		`rsstate`='".mysql_real_escape_string($rsstate)."',
		`rszip`='".mysql_real_escape_string($rszip)."',
		`rstelprivate`= '".mysql_real_escape_string($rstelprivate)."',
		`rstel`='".mysql_real_escape_string($rstel)."',
		`rsfax`='".mysql_real_escape_string($rsfax)."',
		`rswebsite`='".mysql_real_escape_string($rswebsite)."',
		`rsemailprivate`= '".mysql_real_escape_string($rsemailprivate)."',
		`rsemail`='".mysql_real_escape_string($rsemail)."',
		`rsdes`='".mysql_real_escape_string($rsdes)."'
		WHERE `rsid` = '$rsid'";

		return $this->connection->UpdateQuery($query);
	}

	public function getStore($store_id)
	{
		$query = "SELECT * FROM retstores WHERE rsid = ".$store_id;
		return $this->connection->Query($query);
	}

	public function togglePurchaseStatus($id)
	{
		$sql = "SELECT rshdc FROM retstores WHERE rsid = $id";
		$store = $this->connection->Query($sql);
		if($store and $store[0]['rshdc'] == 1)
			$sql1 = "UPDATE retstores SET rshdc = '0' WHERE rsid = $id";
		if($store and $store[0]['rshdc'] == 0)
			$sql1 = "UPDATE retstores SET rshdc = '1' WHERE rsid = $id";
		return $this->connection->UpdateQuery($sql1);
	}

	public function addNewStore($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$query = "INSERT INTO retstores SET 
		rid = '".mysql_real_escape_string($rid)."',
		rshdc = '".mysql_real_escape_string($rshdc)."',
		rsnm = '".mysql_real_escape_string($rsnm)."',
		rsadd = '".mysql_real_escape_string($rsadd)."',
		rscity = '".mysql_real_escape_string($rscity)."', 
		rsstate = '".mysql_real_escape_string($rsstate)."', 
		rszip = '".mysql_real_escape_string($rszip)."',
		rstelprivate = '".mysql_real_escape_string($rstelprivate)."', 
	   	rstel = '".mysql_real_escape_string($rstel)."', 
	    	rsfax = '".mysql_real_escape_string($rsfax)."', 
	    	rswebsite = '".mysql_real_escape_string($rswebsite)."',
	    	rsemailprivate = '".mysql_real_escape_string($rsemailprivate)."',
	    	rsdes='".mysql_real_escape_string($rsdes)."',
	    	rsemail = '".mysql_real_escape_string($rsemail)."'";

	   return $this->connection->InsertQuery($query);
	}

	public function updateStore($post_data)
	{
		if(isset($post_data)) extract($post_data);

		$query = "UPDATE `retstores` SET 
		`rid`='".mysql_real_escape_string($rid)."',
		`rshdc`='".mysql_real_escape_string($rshdc)."',
		`rsnm`='".mysql_real_escape_string($rsnm)."',
		`rsadd`='".mysql_real_escape_string($rsadd)."',
		`rscity`='".mysql_real_escape_string($rscity)."',
		`rsstate`='".mysql_real_escape_string($rsstate)."',
		`rszip`='".mysql_real_escape_string($rszip)."',
		`rstelprivate` = '".mysql_real_escape_string($rstelprivate)."', 
		`rstel`='".mysql_real_escape_string($rstel)."',
		`rsfax`='".mysql_real_escape_string($rsfax)."',
		`rswebsite`='".mysql_real_escape_string($rswebsite)."',
		`rsemailprivate` = '".mysql_real_escape_string($rsemailprivate)."',
		`rsemail`='".mysql_real_escape_string($rsemail)."',
		`rsdes`='".mysql_real_escape_string($rsdes)."'
		WHERE `rsid` = '$rsid'";

		return $this->connection->UpdateQuery($query);
	}
}