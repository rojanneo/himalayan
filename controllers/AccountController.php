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

	public function pricingAction()
	{
		$this->view->render('account/products/pricing.phtml');
	}
	
	public function cpanelAction()
	{
		$this->view->render('account/cpanel/cpanel.phtml');
	}

	public function editAction()
	{
		$this->view->render('account/cpanel/edit.phtml');
	}

	public function editPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		loadHelper('url');
		if($post_data)
		{

			if(getModel('customer')->editInformation($post_data))
			{
				Session::addSuccessMessage('Your Information has been updated.');
				redirect('account/cpanel');
			}
			else
			{
				Session::addErrorMessage('Your Information has not been updated.');
				redirect('account/edit');
			}
		}
		else
		{
				redirect('account/edit');
		}
	}

	public function editPasswordAction()
	{
		loadHelper('inputs');
		loadHelper('url');
		$post_data = getPost();
		extract($post_data);
		if($mid)
		{
			if(getModel('customer')->checkPassword($mid, $oldpassword))
			{
				if($newpassword1 == $newpassword)
				{
					if(getModel('customer')->changePassword($mid, $newpassword))
					{
						Session::addSuccessMessage("Password Successfully Changed");
						redirect('account/cpanel');
					}
					else
					{
						Session::addErrorMessage("Unable to change password");
						redirect('account/edit');
					}

				}
				else
				{

					Session::addErrorMessage("Password Do Not Match");
					redirect('account/edit');
				}
			}
			else
			{
				Session::addErrorMessage("Old Password is incorrect");
				redirect('account/edit');
			}

		}
	}

	public function logoutAction()
	{
		

			Session::session_close();
			loadHelper('url');	
			//var_dump($data['logoutsucess']);
			redirect('');


	}

}