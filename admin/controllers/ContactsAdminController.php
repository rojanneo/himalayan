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
		
		loadHelper('inputs');
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 10;
		$first = ($page-1) * $limit;
		$messages = getModel('contacts')->getMessages($first,$limit);
		$data['messages'] = $messages;

		$data['pagination_num'] = ceil(getModel('contacts')->getMessageCount()/$limit);

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