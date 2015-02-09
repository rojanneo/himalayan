<?php

class ContactsModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function saveMessage($message)
	{
		extract($message);
		if(isset($from_url))
		{
			$query = 'Insert into contact_messages values("","'.$sender_name.'","'.$sender_email.'","'.$message_nature.'","'.$message.'","'.$from_url.'")';
		}
		else
		{
			$query = 'Insert into contact_messages values("","'.$sender_name.'","'.$sender_email.'","'.$message_nature.'","'.$message.'","")';		
		}
		try
		{
			$this->connection->InsertQuery($query);

			$to      = 'info@himalayandogchew.com'; // Put appropirate email in this section
			$subject = 'the subject';
			$message1 = $message; // Put mail content here
			$headers = 'From:  '.$sender_email. "\r\n" .
			    'Reply-To: info@himalandogchew.com' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();
		
			mail($to, $subject, $message1, $headers);
			Session::addSuccessMessage("Your Contact Message Has Been Submitted.");
		}
		catch(Exception $e)
		{
			Session::addErrorMessage($e->getMessage());
		}
	}

	public function getAllMessages()
	{
		$sql = "SELECT * FROM `contact_messages` ORDER BY `contact_id` DESC";
		return $this->connection->Query($sql);
	}

	public function getMessage($id)
	{
		$sql = "SELECT * FROM `contact_messages` WHERE `contact_id` = ".$id;
		return $this->connection->Query($sql)[0];
	}

	public function deleteMessage($id)
	{
		$sql = "DELETE FROM `contact_messages` WHERE `contact_id` = ".$id;
		return $this->connection->DeleteQuery($sql);
	}

	public function getMessages($first,$limit)
	{
		$sql = "SELECT * FROM contact_messages ORDER BY contact_id DESC LIMIT $first, $limit";
		return $this->connection->Query($sql);
	}

	public function getMessageCount()
	{
		$sql = "SELECT * FROM contact_messages";
		return count($this->connection->Query($sql));
	}
}