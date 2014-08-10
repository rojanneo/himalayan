<?php

class StoreModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getStores($retailer_id, $first=0, $limit=10)
	{

		$query = "SELECT * FROM `retstores` WHERE rid=".$retailer_id."  ORDER BY `rsid` DESC LIMIT ".$first.",".$limit;
		$stores = $this->connection->Query($query);
		return $stores;
	}

	public function getStoreCount($retailer_id)
	{
		$query = 'SELECT COUNT(*) FROM retstores WHERE rid='.$retailer_id;
		$count = $this->connection->Query($query);
		return $count;
	}

	public function deleteStore($store_id)
	{
		$query = "DELETE FROM retstores WHERE rsid = ".$store_id;
		return $this->connection->DeleteQuery($query);
	}

	public function saveStore($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$query = "INSERT INTO retstores SET 
		rid = '".mysql_real_escape_string($rid)."',
		rsnm = '".mysql_real_escape_string($rsnm)."',
		rsadd = '".mysql_real_escape_string($rsadd)."',
		rscity = '".mysql_real_escape_string($rscity)."', 
		rsstate = '".mysql_real_escape_string($rsstate)."', 
		rszip = '".mysql_real_escape_string($rszip)."',
	    rstel = '".mysql_real_escape_string($rstel)."', 
	    rsfax = '".mysql_real_escape_string($rsfax)."', 
	    rswebsite = '".mysql_real_escape_string($rswebsite)."',
	    rsemail = '".mysql_real_escape_string($rsemail)."',
	    rsdes = '".mysql_real_escape_string($rsdes)."'";

	   return $this->connection->InsertQuery($query);
	}

	public function updateStoreInfo($post_data)
	{
		if(isset($post_data)) extract($post_data);

		$query = "UPDATE `retstores` SET 
		`rid`='".mysql_real_escape_string($rid)."',
		`rsnm`='".mysql_real_escape_string($rsnm)."',
		`rsadd`='".mysql_real_escape_string($rsadd)."',
		`rscity`='".mysql_real_escape_string($rscity)."',
		`rsstate`='".mysql_real_escape_string($rsstate)."',
		`rszip`='".mysql_real_escape_string($rszip)."',
		`rstel`='".mysql_real_escape_string($rstel)."',
		`rsfax`='".mysql_real_escape_string($rsfax)."',
		`rswebsite`='".mysql_real_escape_string($rswebsite)."',
		`rsemail`='".mysql_real_escape_string($rsemail)."',
		`rsdes`='".mysql_real_escape_string($rsdes)."'
		WHERE `rsid` = '$rsid'";

		return $this->connection->Query($query);
	}

	public function getStore($store_id)
	{
		$query = "SELECT * FROM retstores WHERE rsid = ".$store_id;
		return $this->connection->Query($query);
	}
}