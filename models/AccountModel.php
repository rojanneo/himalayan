<?php

class AccountModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAllForms()
	{
		$query = "SELECT * FROM forms";
		return $this->connection->Query($query);
	}

}