<?php
require_once('system/ImageManipulator.php');
class DashboardAdminController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		loadHelper('url');
		if(!AdminSession::isLoggedIn())
		{
			redirect('admin/login');
		}
	}

	public function indexAction()
	{
		$this->view->renderAdmin('admin/dashboard.phtml');
	}

	public function testAction()
	{
		$this->view->renderAdmin('admin/test.phtml');
	}


	public function modelAction()
	{
		var_dump(getModel('category')->getCategories());
	}

	public function logoutAction()
	{
		AdminSession::session_close();
		loadHelper('url');	
			//var_dump($data['logoutsucess']);
		redirect('admin');
	}
}