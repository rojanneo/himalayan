<?php

class RetailerstoresAdminController extends Controller
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
		$data['stores'] = getModel('store')->getStores($first,$limit);
		$data['pagination_url'] = 'admin/retailerstores/index';
		$data['pagination_num'] = ceil(getModel('store')->getStoreCount()/$limit);
		$this->view->renderAdmin('customers/retailerStores.phtml',$data);
	}

	public function togglesellerAction($store_id)
	{
		getModel('store')->togglePurchaseStatus($store_id);
		redirect('admin/retailerstores');
	}
}