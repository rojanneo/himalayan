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
	
	public function existemail($email)
	{
		$sql = 'SELECT * FROM members where memail="'.$email.'";';
		$query=$this->connection->Query($sql);
		if($query)
		{			
		$code=rand(1000000,99999);
		$to      = $email;
		$subject = 'Reset Your Password';
		$message = 'Hi '.$email.'
			    We got  request to reset your password
			    please click this link '.URL.'/login/resetpassword/?email='.$email.'&key='.$code.'
					';
		$headers = 'From: '.URL.'';
		if(@mail($to, $subject, $message, $headers))
		{
			$sqlinsert='UPDATE `members` SET `activation_code`='.$code.' WHERE `memail`="'.$email.'";';
			$this->connection->UpdateQuery($sqlinsert);			
			return true;
		}
		else
		{
  			return false;
		}
		return true;	
		} 
		else return false;
	}

	public function resetpassword()
	{
		$sql='SELECT `mid` FROM `members` WHERE `memail`="'.$_GET['email'].'" and `activation_code`='.$_GET['key'].'';
		$query=$this->connection->Query($sql);
		if($query)
		{
			$pasword=$this->generateStrongPassword(); 
			$sqlreset="UPDATE `members` SET `mpass`='".mysql_real_escape_string(md5($pasword))."',`activation_code`= NULL WHERE `memail`='".$_GET['email']."'";
			$this->connection->UpdateQuery($sqlreset);	

			$to      = $_GET['email'];
			$subject = 'Password Reset';
			$message = 'Hi '.$_GET['email'].'
				    You haD requested for password reset.
				    Your password for Himalayan Dog Chew has been reset to '.$pasword.'.</br>
			            This password is set by us you can change it to your own after login. </br>.
				    Thankyou.';
			$headers = 'From: '.URL.'';
			mail($to, $subject, $message, $headers);
			return true;
		}
		else { return false; }
	}


	public function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';

	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}

	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];

	$password = str_shuffle($password);

	if(!$add_dashes)
		return $password;

	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
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