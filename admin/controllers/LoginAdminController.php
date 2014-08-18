<?php
class LoginAdminController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		loadHelper('url');
		if(AdminSession::isLoggedIn())
		{
			redirect('admin/dashboard');
		}
	}

	public function indexAction()
	{
		$this->view->renderAdmin('login.phtml', false, false, false);
	}

	public function loginPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		extract($post_data);

		if(($username) and ($password))
		{
			$model = getModel('login');
			if($model->checkAdminLogin($username, $password))
			{
				redirect('admin/dashboard');
			}
			else
			{
				redirect('admin/login');				
			}
		}
		else
		{
			AdminSession::addErrorMessage('Enter Email and Password');
			redirect('admin/login');
		}
	}

}