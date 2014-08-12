<?php
require_once('system/ImageManipulator.php');
class DashboardAdminController extends Controller
{
	public function __construct()
	{
		parent::__construct();
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
}