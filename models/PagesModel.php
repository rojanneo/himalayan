<?php

require_once 'system/model.php';

class PagesModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}	

	public function loadPage($urlkey)
	{
		$query = 'Select * from pages where urlkey = "'.$urlkey.'"';
		$page = $this->connection->Query($query);
		return $page;
	}
}