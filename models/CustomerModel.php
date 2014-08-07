<?php
class CustomerModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCustomerRole($customerId)
	{
		$query = "SELECT * FROM members WHERE mid='$customerId'";
		$customer = $this->connection->Query($query);
		return $customer[0]['mtype'];
	}
}