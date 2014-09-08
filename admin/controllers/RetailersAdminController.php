<?php

class RetailersAdminController extends Controller
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
		loadHelper('inputs');
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 100;
		$first = ($page-1) * $limit;

		$status_filter = getParam('status');
		$state_filter = getParam('state');
		$city_filter = getParam('city');
		if(!$status_filter) $status_filter = 'all';
		if(!$state_filter) $state_filter = 'all';
		if(!$city_filter) $city_filter = 'all';

		if($state_filter == 'all')
		{
			$data['cities'] = getModel('customer')->getAllCities();
		}
		else
		{
			$data['cities'] = getModel('customer')->getCitiesByState($state_filter);
		}


		$data['states'] = getModel('customer')->getAllStates();

		$retailers = getModel('customer')->getRetailersByFilter($status_filter, $state_filter, $city_filter, $first, $limit);
		$data['pagination_url'] = "admin/retailers/index?state=$state_filter&city=$city_filter&status=$status_filter";
		$data['pagination_num'] = ceil(count(getModel('customer')->getRetailersByFilter($status_filter, $state_filter, $city_filter, 0, getModel('customer')->getRetailerCount()))/$limit);
		$data['retailers'] = $retailers;

		$this->view->renderAdmin('customers/grid.phtml',$data);
	}

	public function confirmAction($id)
	{
		getModel('customer')->confirm_reject($id);
		redirect('admin/retailers');
	}

	public function allowpurchaseAction($id)
	{
		getModel('customer')->allowPurchase($id);
		redirect('admin/retailers');
	}

	public function disallowpurchaseAction($id)
	{
		getModel('customer')->disallowPurchase($id);
		redirect('admin/retailers');
	}


	public function onlineAction($id)
	{
		getModel('customer')->online($id);
		redirect('admin/retailers');
	}

	public function addAction()
	{
		$this->view->renderAdmin('customers/retaileradd.phtml');
	}

	public function addPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		getModel('customer')->addNewRetailer($post_data);
		redirect('admin/retailers');
	}

	public function editAction($id)
	{
		$data['retailer'] = getModel('customer')->getRetailer($id);
		$this->view->renderAdmin('customers/retaileradd.phtml',$data);
	}

	public function editPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		getModel('customer')->updateRetailer($post_data);
		redirect('admin/retailers');
	}
}