<?php

class DashboardAdminController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function indexAction()
	{
		echo 'admin dashboard';
	}

	public function testAction()
	{
		$this->view->renderAdmin('admin/test.phtml');
	}


	public function modelAction()
	{
		var_dump(getModel('category')->getCategories());
	}
}