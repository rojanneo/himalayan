<?php

class AccountController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!Session::isLoggedIn())
		{
			loadHelper('url');
			redirect('login');
		}
	}

	public function indexAction()
	{
		$this->view->render('account/dashboard.phtml');
	}

	public function formsAction()
	{
		$forms = getModel('account')->getAllForms();
		$data['forms'] = $forms;

		$this->view->render('account/forms.phtml',$data);
	}

}