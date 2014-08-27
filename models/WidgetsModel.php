<?php

class WidgetsModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getWidgets()
	{
		$query = 'Select * from widgets';		
		return $this->connection->Query($query);
	}
	public function getWidgetById($attribute_id)
	{
		$query="SELECT * FROM `widgets` WHERE `widget_id`='".$attribute_id."'";
		return $this->connection->Query($query);
	}

	public function addWidgetpostcontent($identifier)
	{
		$query="SELECT * FROM `widgets` WHERE `widget_identifier`='".$identifier."'";
		$widget = $this->connection->Query($query);
		if(($widget)) return $widget[0]['widget_content'];
		else return false;

	}

	public function addWidgetpost($post_data)
	{
		if($post_data) extract($post_data);			
		$sqlbname="SELECT * FROM `widgets` WHERE `widget_identifier`='".$widentifier."'";
		$sqlbnameexsit=$this->connection->Query($sqlbname);
		if(!empty($sqlbnameexsit))
		{			
			return false;
		}
		else
		{
			$sql="INSERT INTO `widgets`(`widget_name`, `widget_identifier`, `widget_title`, `widget_content`) VALUES ('".$wname."','".$widentifier."','".$wtitle."','".$wcontent ."')";
			return $this->connection->InsertQuery($sql);
		}	
			
	}

	public function updateWidget($post_data)
	{
		$now=date('Y-m-d H:i:s'); 
		if($post_data) extract($post_data);	
		$sql="UPDATE `widgets` SET `widget_name`='".$wname."',`widget_identifier`='".$widentifier."',`widget_title`='".$wtitle."',`widget_content`='".$wcontent."',`widget_revised`='".$now."' WHERE `widget_id`='".$w_id."'";
		return $this->connection->UpdateQuery($sql);
	}

	public function deleteWidgetPost($w_id)
	{ 
		//var_dump($blog_id); die();
		$sql="DELETE FROM `widgets` WHERE `widget_id`='".$w_id."'";

		if($this->connection->DeleteQuery($sql))
		{
			return true;
		}
		else 
			return'error in database';
		
	}
}