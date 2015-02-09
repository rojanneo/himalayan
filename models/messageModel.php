<?php

class messageModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function sendNewPrivateMessage($data)
	{
		extract($data);
		$sql = "INSERT INTO `messages`(
		`message_subject`, `message_body`, `message_department_id`, `message_employee_id`, `message_status`) 
		VALUES (
			'".mysql_escape_string($message_subject)."',
			'".mysql_escape_string($message_body)."',
			'NULL',
			'".mysql_escape_string($employee_id)."',
			'unread')";	

		$this->connection->InsertQuery($sql);

		return $this->connection->GetInsertID();	
	}


}