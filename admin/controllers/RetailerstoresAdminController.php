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
		//if(isset($_POST['storename'])){ echo "hye"; die();}
		loadHelper('inputs');
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 100;
		$first = ($page-1) * $limit;
		$retailer = getParam('retailer');
		if(!$retailer) $retailer = 'all';

		if(isset($_POST['storename']) || isset($_GET['store']))
		{
			if(isset($_POST['storename'])) { $storenameval=$_POST['storename'];	 }
			else {$storenameval=$_GET['store']; 										 }
		$storeslist	= getModel('store')->getstorebyname($first,$limit,$storenameval,false);
		if(getModel('store')->getstorebyname($first,$limit,$storenameval,false))
		{	
			$data['stores']=$storeslist; 
				$data['pagination_url'] = 'admin/retailerstores/?store='.$storenameval.'&';
				$data['pagination_num'] = ceil(getModel('store')->getstorebyname(null,null,$storenameval,'count')/$limit);
			$this->view->renderAdmin('customers/retailerStores.phtml',$data); 

		}
		else { $this->view->renderAdmin('customers/retailerStores.phtml'); }
		}

		elseif($retailer == 'all')
		{

		$data['stores'] = getModel('store')->getStores($first,$limit);
		$data['pagination_url'] = 'admin/retailerstores/index';
		$data['pagination_num'] = ceil(getModel('store')->getStoreCount()/$limit);
		$this->view->renderAdmin('customers/retailerStores.phtml',$data);

		}

		else
		{
			$data['stores'] = getModel('store')->getStores($first,$limit,$retailer);
			$this->view->renderAdmin('customers/retailerStores.phtml',$data);			
		}
	}

	public function togglesellerAction($store_id)
	{
		getModel('store')->togglePurchaseStatus($store_id);
		redirect('admin/retailerstores');
	}

	public function addAction()
	{
		$this->view->renderAdmin('customers/addstore.phtml');
	}

	public function addPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		getModel('store')->addNewStore($post_data);
		redirect('admin/retailerstores');
	}

	public function editAction($id)
	{
		$retailer = getModel('store')->getStore($id);
		$data['store'] = $retailer[0];
		$this->view->renderAdmin('customers/addstore.phtml',$data);
	}

	public function editPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		getModel('store')->updateStore($post_data);
		redirect('admin/retailerstores');
	}
}