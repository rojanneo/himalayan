<?php
class ProductsModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAvailableProductTypes()
	{
		$query = "SELECT * FROM ptype";
		$types = $this->connection->Query($query);
		return $types;
	}
}