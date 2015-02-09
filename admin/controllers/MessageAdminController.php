<?php
class MessageAdminController extends Controller
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

	public function sendNewMessageAction()
	{
		$this->view->renderAdmin('message/new.phtml');		
	}

	public function sendNewMessagePostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();

		if(isset($post_data['employee_id']))
		{
			if(getModel('message')->sendNewPrivateMessage($post_data))
			{
				AdminSession::addSuccessMessage('Message Sent');
			}
			else
			{
				AdminSession::addErrorMessage('Could Not Send Private Message');
			}
			redirect('admin/dashboard');
		}

	}

}