<?php

//require_once('system/model.php');
class HomeModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getWhatOthersSay($type)
	{
		$query = "Select * from whatotherssay where type='".$type."'";
		$what = $this->connection->Query($query);
		return $what;
	}

	public function getUpcomingEvents()
	{
		$query = "SELECT * FROM events WHERE eventDateEnd > now()";
		$events = $this->connection->Query($query);
		return $events;
	}

	public function getBlogPosts()
	{
		$query="SELECT * FROM blog WHERE blog_status='publish' ORDER BY blog_id DESC LIMIT 3";
		return $this->connection->Query($query);
	}

	public function getBlogByVal($attribute_val)
	{
		$query="SELECT * FROM `blog` WHERE blog_name='".$attribute_val."' AND blog_status='publish'";
		$sql=$this->connection->Query($query);
		if($sql)
		return $sql[0];
		else { return false; }
	}
}