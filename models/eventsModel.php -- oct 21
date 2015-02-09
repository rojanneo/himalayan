<?php

class EventsModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getEvents($first, $limit)
	{
		$query = "Select * from event ORDER BY event_id DESC LIMIT $first, $limit";		
		return $this->connection->Query($query);
	}

	public function getEventCount()
	{
		$sql = "SELECT * FROM event";
		return count($this->connection->Query($sql));
	}
	public function getEventById($attribute_id)
	{
		$query="SELECT * FROM `event` WHERE `event_id`='".$attribute_id."'";
		return $this->connection->Query($query);
	}

	public function addEventpost($post_data)
	{
		if($post_data) extract($post_data);	
		$eventslug=str_replace(" ","_",$ename);
		/*if(!empty($eurl))
		{
			$eventguid=$eurl;
		}
		else{ $eventguid=URL.$eventslug; }*/
		$sqlbname="SELECT * FROM `event` WHERE `eventslug`='".$eventslug."'";
		$sqlbnameexsit=$this->connection->Query($sqlbname);
		if(!empty($sqlbnameexsit))
		{			
			$eventslug=$eventslug.uniqid();
		}	
			$sql="INSERT INTO `event`(`eventName`, `eventslug`, `eventDateBegin`, `eventDateEnd`, `eventDesc`, `eventUrl`, `eventstatus`, `event_feature_image`) VALUES ('".$ename."','".$eventslug."','".$ebegindate."','".$eendndate ."','".$econtent."','".$eventguid."','".$estatus."','".$efimage."')";
			return $this->connection->InsertQuery($sql);
	}

	public function updateEvents($post_data)
	{
		$now=date('Y-m-d H:i:s'); 
		if($post_data) extract($post_data);
		$eventslug=str_replace(" ","_",$ename);
		/*if(!empty($eurl))
		{
			$eurl=$eurl;
		}
		else{ $eurl=URL.$eventslug; }*/
		$sql="UPDATE `event` SET `eventName`='".$ename."',`eventDateBegin`='".$ebegindate."',`eventDateEnd`='".$eendndate."',`eventDesc`='".$econtent."',`eventUrl`='".$eurl."',`eventstatus`='".$estatus."',`event_feature_image`='".$efimage."',`event_revised_date`='".$now."' WHERE `event_id`='".$event_id."'";
		return $this->connection->UpdateQuery($sql);
	}

	public function deleteEventPost($event_id)
	{ 
		//var_dump($blog_id); die();
		$sql="DELETE FROM `event` WHERE `event_id`='".$event_id."'";

		if($this->connection->DeleteQuery($sql))
		{
			return true;
		}
		else 
			return'error in database';
		
	}
}