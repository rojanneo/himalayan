<?php

//require_once('system/model.php');
class LoginModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function login_check($username,$password)
	{
		$pass = md5($password);
		$query = "Select * from members where memail='".$username."' and mpass='".$pass."'";
		$what = $this->connection->Query($query);
		if(!empty($what))
		{
			$data['message']=Session::createNewSession($what);
			//$data['session']=$_SESSION['token'];
			//var_dump($data); die();
			return true;
		}
		else
		{		
		//$data['session']=$_SESSION['token'];
			$data['message']='Username OR Password Donnt Match';
		//var_dump($data);	die();		
			return false;
		}

		//Session::createNewSession();
		//$this->session->createNewSession($userid);




//		return $what;

		
	}

	public function emailExists($email, $pass)
	{
		$password = md5($pass);
		$query = 'SELECT * FROM members where memail="'.$email.'";';
		$count = $this->connection->GetRowCount($query);
		if($count > 0)
		{
			Session::addErrorMessage('Email Already Exists');
			return true;
		}
		return false;
	}

	public function register($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$mdate = date('Y-m-d');
		$query = "INSERT INTO members SET mname = '".mysql_real_escape_string($mname)."', memail = '".mysql_real_escape_string($memail)."',
		mpass = '".mysql_real_escape_string(md5($mpass))."', madd = '".mysql_real_escape_string($madd)."', madd2 = '".mysql_real_escape_string($madd2)."',
	    mcity = '".mysql_real_escape_string($mcity)."', mstate = '".mysql_real_escape_string($mstate)."', mzip = '".mysql_real_escape_string($mzip)."',
	    mtel = '".mysql_real_escape_string($mtel)."', mfax = '".mysql_real_escape_string($mfax)."', mcompany = '".mysql_real_escape_string($mcompany)."',
	    mein = '".mysql_real_escape_string($mein)."', mdate = '".mysql_real_escape_string($mdate)."', mtype = '".mysql_real_escape_string($mtype)."',
	    mdes = '', mlist = '0', mconfirm = '0'";

	    return $this->connection->InsertQuery($query);
	}
}