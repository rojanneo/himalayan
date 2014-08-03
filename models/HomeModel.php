<?php

require_once('system/model.php');
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
}