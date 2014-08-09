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
				redirect('account');
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

			if(getModel('login')->register($post_data))
			{
				Session::addSuccessMessage('Your Request has been successfully submitted. We will verify and approve your request shortly.');
				redirect('login/registerSuccess');
			}
			else
			{
				redirect('login/register');
			}
		}
		else
		{
			redirect('login/register');
		}
		
	}

}