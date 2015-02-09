<?php

class LoginController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		loadHelper('url');	
		if(Session::isLoggedIn())
		{
			redirect('account');
		}
	}

	public function indexAction()
	{
		//Session::test();
		
	//	$data['alina']='hey';
		//$data['loginchecks']=$_SESSION['token'];
		

		if(Session::getSessionId())
		{
			//$data['loginchecks']='Already Loggedin';
			$this->view->render('login/login.phtml');
		}
		else
		{
			//echo'nosession';
		$this->view->render('login/login.phtml');
		}
	}

	

	public function logintoAction()
	{
		loadHelper('inputs');
		loadHelper('url');
		$username = getPost('username');
		$password = getPost('password');
		if(Session::isLoggedIn()){
			//$data['loginchecks']='Already Loggedin';
			redirect('account');
		}
		elseif($username && $password)
		{
			$model = getModel('login');
			$loginchecks = $model->login_check($username,$password);
			if($loginchecks)
				redirect('account/pricing');
			else redirect('login');

		}
		else
		{
			redirect('login');
		}
	}

	public function registerAction()
	{
		$this->view->render('login/register.phtml');
	}

	public function registerSuccessAction()
	{
		$this->view->render('login/registerSuccess.phtml');
	}

	public function registerPostAction()
	{//die('here');
		loadHelper('inputs');
		$post_data = getPost();
		loadHelper('url');
		if($post_data)
		{
			$email = $post_data['memail'];
			$pass = $post_data['mpass'];
			if(getModel('login')->emailExists($email, $pass))
			{
				redirect('login/register');
			}

			else
			{
				if(getModel('login')->register($post_data))
				{
					if($post_data['mtype'] == 'retailer')
						Session::addSuccessMessage('Your Request has been successfully submitted. We will verify and approve your request shortly.');
					else
						Session::addSuccessMessage('Thank you! Your Information has been successfully recorded.');
					redirect('login/registerSuccess');
				}
				else
				{
					redirect('login/register');
				}
			}
		}
		else
		{
			redirect('login/register');
		}
		
	}
	
	
	public function forgotpasswordAction()
	{
		$this->view->render('login/forgetpassword.phtml');
	}

	public function forgetpasswordprocessAction()
	{
		$conform=getModel('login')->existemail($_POST['email']);
		if($conform)
		{
			$data['verified']="Thankyou . We have send you confirmation link. Please Check your mail for confirmation.";
			$this->view->render('login/forgetpassword.phtml',$data);
		}
		else
		{
			$data['notverified']="Sorry the email address doesnot exsist. please Enter the verified Email Address.";
			$this->view->render('login/forgetpassword.phtml',$data);		
		}
	}

	public function resetpasswordAction()
	{		 
		$restprocess=getModel('login')->resetpassword();
		if($restprocess)
		{
		$this->view->render('login/resetpassword.phtml');
		}
		else
		{
			$data['notconfirm']="Sorry, Please check your email again.";
			$this->view->render('login/resetpassword.phtml',$data);
		}
	}

}