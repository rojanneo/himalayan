<?php

//require_once('system/model.php');
class LoginModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function checkAdminLogin($username, $password)
	{
		$pass = md5($password);
		$query = "SELECT employee_login.eid, employee_login.memail, employee_login.mpass, employee_login.etid FROM 
		(SELECT * FROM `employees` JOIN members ON members.mid = employees.eid) as employee_login 
		WHERE employee_login.memail = '".$username."' AND employee_login.mpass = '".$pass."'";
		$what = $this->connection->Query($query);
		if(!empty($what))
		{
			$data['message']=AdminSession::createNewSession($what);
			//$data['session']=$_SESSION['token'];
			//var_dump($data); die();
			return true;
		}
		else
		{		
			{
				AdminSession::addErrorMessage('Username or Password Incorrect');
			}
			return false;
		}
	}

	public function login_check($username,$password)
	{
		$pass = md5($password);
		$query = "Select * from members where memail='".$username."' and mpass='".$pass."'";
		$what = $this->connection->Query($query);
		if(!empty($what) and $what[0]['mconfirm'] == 1)
		{
			$data['message']=Session::createNewSession($what);
			//$data['session']=$_SESSION['token'];
			//var_dump($data); die();
			return true;
		}
		else
		{		
		//$data['session']=$_SESSION['token'];
			if(!empty($what))
			{
				Session::addErrorMessage('Account has not been activated');
			}
			else
			{
				Session::addErrorMessage('Username or Password Incorrect');
			}

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
		//echo $count;die;
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
		if(!isset($mcompany)) $mcompany='';
		if(!isset($mein)) $mein = '';
		$query = "INSERT INTO members SET mname = '".mysql_real_escape_string($mname)."', memail = '".mysql_real_escape_string($memail)."',
		mpass = '".mysql_real_escape_string(md5($mpass))."', madd = '".mysql_real_escape_string($madd)."', madd2 = '".mysql_real_escape_string($madd2)."',
	    mcity = '".mysql_real_escape_string($mcity)."', mstate = '".mysql_real_escape_string($mstate)."', mzip = '".mysql_real_escape_string($mzip)."',
	    mtel = '".mysql_real_escape_string($mtel)."', mfax = '".mysql_real_escape_string($mfax)."', mcompany = '".mysql_real_escape_string($mcompany)."',
	    mein = '".mysql_real_escape_string($mein)."', mdate = '".mysql_real_escape_string($mdate)."', mtype = '".mysql_real_escape_string($mtype)."',
	    mdes = '', mlist = '1', mconfirm = '0'";

	   if($this->connection->InsertQuery($query))
	   {
	   		$type = $mtype;
	   		if($type == 'retailer')
	   		{
	   			$insert_id = $this->connection->GetInsertID();
	   			$query = "INSERT INTO `retailers`(`rid`, `rcompany`, `rein`, `rwebsite`, `retailerSellOnline`, 
	   				`regtype`, `rqual`, `rterm`, `rship`, `rshipqual`, `rauth`, `rinformed`) 
	   			VALUES (".$insert_id.",'".mysql_real_escape_string($mcompany)."','".mysql_real_escape_string($mein)."','".mysql_real_escape_string($mwebsite)."',
	   				'','web','','','0','0','','0')";
				$query2 = "INSERT INTO `member_mtype`(`member_mtype`, `member_id`, `membertype_id`) VALUES ('',".$insert_id.",3)";
				return $this->connection->InsertQuery($query) && $this->connection->InsertQuery($query2);
	   		}
	   		else if($type == 'customer')
	   		{
	   			$insert_id = $this->connection->GetInsertID();
	   			$query = "INSERT INTO `customer`(`customer_id`, `cname`, `cemail`) VALUES ($insert_id,'".mysql_real_escape_string($mname)."','".mysql_real_escape_string($memail)."')";
				$query2 = "INSERT INTO `member_mtype`(`member_mtype`, `member_id`, `membertype_id`) VALUES ('',".$insert_id.",8)";
				return $this->connection->InsertQuery($query) && $this->connection->InsertQuery($query2);
	   		}
	   }
	   else 
	   {
	   	return false;
	   }
	}

	
}