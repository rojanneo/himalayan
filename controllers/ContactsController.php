<?php

class ContactsController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function indexAction()
	{
		$this->view->render('contacts/form.phtml');
	}

	public function messagePostAction()
	{
		loadHelper('inputs');
		loadHelper('url');
		$post_data = getPost();
		getModel('contacts')->saveMessage($post_data);
		redirect('contacts');

	}
}