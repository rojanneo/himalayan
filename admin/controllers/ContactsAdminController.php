<?php
class ContactsAdminController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		loadHelper('url');
		if(!AdminSession::isLoggedIn())
		{
			//die('here');
			redirect('admin/login');
		}
	}

	public function indexAction()
	{
		$messages = getModel('contacts')->getAllMessages();
		$data['messages'] = $messages;

		$this->view->renderAdmin('contacts/grid.phtml',$data);
	}

	public function viewAction($id)
	{
		$message = getModel('contacts')->getMessage($id);
		$data['message'] = $message;
		$this->view->renderAdmin('contacts/view.phtml',$data);
	}

	public function deleteAction($id)
	{
		getModel('contacts')->deleteMessage($id);
		redirect('admin/contacts');
	}
}