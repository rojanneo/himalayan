<?php
class CustomerModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCustomerRole($customerId)
	{
		// $query = "SELECT * FROM members WHERE mid='$customerId'";
		// $customer = $this->connection->Query($query);
		$customer = $this->getCustomer($customerId);
		return $customer['mtype'];
	}

	public function getCustomer($customerId)
	{
		$query = "SELECT * FROM members WHERE mid = '$customerId'";
		$customer = $this->connection->Query($query);
		return $customer[0];
	}

	public function editInformation($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$mdate = date('Y-m-d');
		$pass = md5($mpass);
		$query = "UPDATE `members` SET 
		`mname`='".mysql_real_escape_string($mname)."',
		`memail`='".mysql_real_escape_string($memail)."',
		`madd`='".mysql_real_escape_string($madd)."',
		`madd2`='".mysql_real_escape_string($madd2)."',
		`mcity`='".mysql_real_escape_string($mcity)."',
		`mstate`='".mysql_real_escape_string($mstate)."',
		`mzip`='".mysql_real_escape_string($mzip)."',
		`mtel`='".mysql_real_escape_string($mtel)."',
		`mfax`='".mysql_real_escape_string($mfax)."',
		`mcompany`='".mysql_real_escape_string($mcompany)."'
		WHERE `mid` = '$mid'";
		return $this->connection->UpdateQuery($query);
	}

	public function checkPassword($customerId, $pass)
	{
		$customer = $this->getCustomer($customerId);
		if($customer['mpass'] == md5($pass))
		{
			return true;
		}
		else
			return false;
	}

	public function changePassword($customerId, $pass)
	{
		$pass=md5($pass);
		$query = "UPDATE `members` SET `mpass`='".$pass."' WHERE `mid`='$customerId'";
		return $this->connection->UpdateQuery($query);
	}
}