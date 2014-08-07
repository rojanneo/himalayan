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
		try
		{
			$this->connection->InsertQuery($query);

			$to      = 'rojan.ku@gmail.com'; // Put appropirate email in this section
			$subject = 'the subject';
			$message = 'hello'; // Put mail content here
			$headers = 'From:  info@himalandogchew.com' . "\r\n" .
			    'Reply-To: info@himalandogchew.com' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();
		
			mail($to, $subject, $message, $headers);
			Session::addSuccessMessage("Your Contact Message Has Been Submitted.");
		}
		catch(Exception $e)
		{
			Session::addErrorMessage($e->getMessage());
		}
	}
}