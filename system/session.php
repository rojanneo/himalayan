<?php
	
	require_once('system/connection.php');
	class Session
	{

	private static $instance = NULL;
	public static $connection;
		

	private function __construct()
	{
		$this->connection = Connection::GetInstance();
	}

	public function GetInstance()
	{

		if(!self::$instance)
		{
			
			self::$instance = new Session();
		}
		return self::$instance;
	}



	public static function createNewSession($what)
	{	
			$sessionstore="INSERT INTO  user_session (user_id,token_id) values ('".$what[0]['user_id']."','".$what[0]['username']."')";
			$sessdata=self::GetInstance()->connection->InsertQuery($sessionstore);
			//need to check if the data is inserted into the session table and then only apple the condition to initialze the sessionvariable value
			$_SESSION['token']=$what[0]['username'];
			return 'login succesfull';
	}
	
	public static function session_start($type)
	{
		session_start();	
	}

	// CREATE SESSION
	public static function create_session($token_id)
	{
		$_SESSION['token_id'] = $token_id;
	}

	public static function getCurrentSession($token)
	{
		self::GetInstance();
		$sessionv="Select * from user_session where token_id='".$token."'";
		$ses_cur_val = self::GetInstance()->connection->Query($sessionv);

		//$ses_cur_val=$this->connection->Query($sessionv);
		return $ses_cur_val;
	}

	
	public static function session_close()
	{
		$currentsession=$_SESSION['token'];
		$sessiondelete="DELETE FROM  user_session  WHERE token_id='".$currentsession."'";
		$sessdeldata=self::GetInstance()->connection->DeleteQuery($sessiondelete);
		unset($_SESSION['token']);
		return $sessdeldata;

	}
}
?>