<?php

class AttributesetModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAllAttributeSets()
	{
		$query = "SELECT * FROM attributeset";
		$sets = $this->connection->Query($query);
		return $sets;
	}
}