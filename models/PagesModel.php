<?php

//require_once 'system/model.php';

class PagesModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}	

	public function loadPage($urlkey)
	{
		$query = 'Select * from pages where urlkey = "'.$urlkey.'" AND status = 1';
		$page = $this->connection->Query($query);
		return $page;
	}

	public function getAllPages()
	{
		$query = "SELECT * FROM pages";
		return $this->connection->Query($query);
	}

	public function getPageById($id)
	{
		$query = "SELECT * FROM pages WHERE page_id = $id";
		return $this->connection->Query($query)[0];
	}

	public function addNewPage($post_data)
	{
		if($post_data) extract($post_data);
		$query = "INSERT INTO `pages`(`urlKey`, `title`, `content`, `status`) VALUES ('$urlKey','$title','$content',$status)";
		return $this->connection->InsertQuery($query);
	}

	public function updatePage($post_data)
	{
		if($post_data) extract($post_data);
		$query = "UPDATE `pages` SET `urlKey`='$urlKey',`title`='$title',`content`='$content',`status`=$status WHERE page_id = $page_id";
		return $this->connection->UpdateQuery($query);
	}
}