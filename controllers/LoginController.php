<?php

class LoginController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function indexAction()
	{
		//Session::test();
		
	//	$data['alina']='hey';
		//$data['loginchecks']=$_SESSION['token'];
		if(isset($_SESSION['token']))
		{
			$data['loginchecks']='Already Loggedin';
			$this->view->render('login/login.phtml',$data);
		}
		else
		{
			//echo'nosession';
		$this->view->render('login/login.phtml');
		}
	}

	public function logoutsAction()
	{
		

			$data['logoutsucess']=Session::session_close();	
			//var_dump($data['logoutsucess']);
			header( 'Location: '.URL.'' );


	}

	public function logintoAction()
	{

		if(isset($_SESSION['token'])){
			$data['loginchecks']='Already Loggedin';
			$this->view->render('login/login.phtml',$data);
		}
		elseif(isset($_POST['username'])&&isset($_POST['password']))
		{
			$model = getModel('login');
			$loginchecks = $model->login_check($_POST['username'],$_POST['password']);
			$data['loginchecks'] = $loginchecks;
			$this->view->render('login/login.phtml',$data);

		}
		else
		{
			loadHelper('url');
			redirect('login');
		}
	}

}