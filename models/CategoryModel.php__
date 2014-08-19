<?php

class CategoryModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCategories()
	{
		$query = 'Select * from categories';
		$categories = $this->connection->Query($query);
		return $categories;
	}
}