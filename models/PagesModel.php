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
		$query = "INSERT INTO `pages`(`urlKey`, `title`, `content`, `status`) VALUES ('$urlKey','$title','".mysql_real_escape_string($content)."',".$status.")";
		return $this->connection->InsertQuery($query);
	}

	public function updatePage($post_data)
	{
		if($post_data) extract($post_data);
		$sql = "UPDATE `pages` SET	`urlKey`='".mysql_real_escape_string ($urlKey)."',`title`='".mysql_real_escape_string($title)."',`content`='".mysql_real_escape_string($content)."',`status`=".mysql_real_escape_string($status)." WHERE `page_id` = ".mysql_real_escape_string($page_id);	
		return $this->connection->UpdateQuery($sql);
	}

	public function getPages($first,$limit)
	{
		$sql = "SELECT * FROM pages ORDER BY page_id DESC Limit $first,$limit";
		return $this->connection->Query($sql);
	}

	public function getPagesCount()
	{
		$sql = "SELECT * FROM pages";
		return count($this->connection->Query($sql));
	}

	public function deletePage($id)
	{
		$sql = "DELETE FROM pages WHERE page_id = $id";
		return $this->connection->DeleteQuery($sql);
	}
}

