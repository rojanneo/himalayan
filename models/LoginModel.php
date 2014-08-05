<?php

//require_once('system/model.php');
class LoginModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function login_check($usernane,$password)
	{
		$query = "Select * from users where username='".$usernane."' and password='".$password."'";
		$what = $this->connection->Query($query);
		if(!empty($what))
		{
			$data['message']=Session::createNewSession($what);
			//$data['session']=$_SESSION['token'];
			//var_dump($data); die();
			return $data['message'];
		}
		else
		{		
		//$data['session']=$_SESSION['token'];
			$data['message']='Username OR Password Donnt Match';
		//var_dump($data);	die();		
			return $data['message'];
		}

		//Session::createNewSession();
		//$this->session->createNewSession($userid);




//		return $what;

		
	}
}