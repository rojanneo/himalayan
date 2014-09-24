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
		$forms = getModel('form')->getAllForms();
		$data['forms'] = $forms;

		$this->view->render('account/forms.phtml',$data);
	}

	public function pricingAction()
	{
		$products = getModel('products')->getActiveProducts();
		$data['products'] = $products;
		$this->view->render('account/products/pricing.phtml', $data);
	}
	
	public function cpanelAction()
	{
		$this->view->render('account/cpanel/cpanel.phtml');
	}

	public function distributorsAction()
	{
		$this->view->render('default/under-construction.phtml');
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

	public function storesAction()
	{
		loadHelper('url');
		loadHelper('inputs');
		$session = Session::getCurrentSession();
		$role = getModel('customer')->getCustomerRole($session['user_id']);
		if($role != 'retailer')
		{
			redirect('home/pagenotfound');
		}

		$session = Session::getCurrentSession();
		$retailer_id = $session['user_id'];
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 10;
		$first = ($page-1) * $limit;
		$stores = getModel('store')->getStores($first,$limit,$retailer_id);
		$data = array();
		if(count($stores) > 0)
			$data['stores'] = $stores;

		$num = getModel('store')->getStoreCount($retailer_id)[0];
		if($limit < $num["COUNT(*)"])
			$data['pagination_num'] = ceil($num["COUNT(*)"]/$limit);
		$this->view->render('account/cpanel/stores.phtml',$data);
	}

	public function addStoreAction()
	{
		$session = Session::getCurrentSession();
		$role = getModel('customer')->getCustomerRole($session['user_id']);
		if($role != 'retailer')
		{
			redirect('home/pagenotfound');
		}
		$retailer_id = $session['user_id'];
		$data['rid'] = $retailer_id;
		$this->view->render('account/cpanel/addstore.phtml',$data);
	}

	public function addStorePostAction()
	{
		loadHelper('inputs');
		loadHelper('url');
		$post_data = getPost();
		if(getModel('store')->saveStore($post_data))
		{
			Session::addSuccessMessage('Store Added Successfully.');
			redirect('account/stores');
		}
		else
		{
			Session::addErrorMessage('Failed to add a store.');
			redirect('account/stores');
		}
	}

	public function editStoreAction($store_id)
	{
		loadHelper('url');
		$session = Session::getCurrentSession();
		$role = getModel('customer')->getCustomerRole($session['user_id']);
		if($role != 'retailer')
		{
			redirect('home/pagenotfound');
		}
		$retailer_id = $session['user_id'];
		$data['rid'] = $retailer_id;
		$store = getModel('store')->getStore($store_id);
		$data['store'] = $store[0];
		$this->view->render('account/cpanel/addstore.phtml',$data);
	}

	public function editStorePostAction()
	{
		loadHelper('inputs');
		loadHelper('url');
		$post_data = getPost();
		if(getModel('store')->updateStoreInfo($post_data))
		{
			Session::addSuccessMessage("Store Information Successfully Updated");
			redirect('account/stores');
		}
		else
		{
			Session::addSuccessMessage("Unable to update store information");
			redirect('account/stores');			
		}
	}

	public function retailerContactsAction()
	{
		$rid = Session::getCurrentSession()['user_id'];
		$data = null;
		if($rid)
		{
			$contacts = getModel('retailercontact')->getContacts($rid);
			$data['contacts'] = $contacts;
		}
		$this->view->render('account/cpanel/retailerContacts.phtml',$data);
	}

	public function addRetailerContactAction()
	{
		$this->view->render('account/cpanel/addRetailerContact.phtml');
	}

	public function guaranteeAction()
	{
		$this->view->render('account/cpanel/guarantee.phtml');
	}

	public function shippingAction()
	{
		$this->view->render('account/cpanel/shipping.phtml');
	}


	public function addRetailerContactPostAction()
	{
		loadHelper('inputs');
		loadHelper('url');
		$post_data = getPost();
		$model = getModel('retailercontact');
		if(!getModel('login')->emailExists($post_data['memail'], ''))
		{
			$model->registerContact($post_data);
			redirect('account/retailercontacts');
		}
		else
		{
			redirect('account/retailercontacts');
		}		

	}

	public function editRetailerContactAction($id)
	{
		$contact = getModel('retailercontact')->getContact($id);
		$member = getModel('customer')->getCustomer($contact['mid']);
		$data['contact'] = $contact;
		$data['member'] = $member;
		$this->view->render('account/cpanel/addRetailerContact.phtml',$data);
	}

	public function editRetailerContactPostAction()
	{
		loadHelper('inputs');
		loadHelper('url');
		$post_data = getPost();
		if(getModel('retailercontact')->updateContact($post_data))
		{
			redirect('account/retailercontacts');
		}
		else
			redirect('account/retailercontacts/editRetailerContact/'.$post_data['retailer_contact_id']);
	}

	public function deleteContactAction($id)
	{
			loadHelper('url');
		if(getModel('retailercontact')->deleteContact($id))
		{
			Session::addSuccessMessage('Contact Deleted');
			redirect('account/retailercontacts');
		}
		else
		{
			redirect('account/retailercontacts');
		}
	}

	public function deleteStoreAction($store_id)
	{
		loadHelper('url');
		if(getModel('store')->deleteStore($store_id))
			Session::addSuccessMessage('Store Deleted');
		redirect('account/stores');
	}

	public function logoutAction()
	{
		

			Session::session_close();
			loadHelper('url');	
			//var_dump($data['logoutsucess']);
			redirect('');


	}

}