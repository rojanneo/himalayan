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
		$query = 'Insert into contact_messages values("","'.$sender_name.'","'.$sender_email.'","'.$message_nature.'","'.$message.'")';
		
		$this->connection->InsertQuery($query);

		$to      = 'rojan.ku@gmail.com';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: rojan.neo@gmail.com' . "\r\n" .
		    'Reply-To: rojan.neo@gmail.com' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		try
		{
			mail($to, $subject, $message, $headers);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
}