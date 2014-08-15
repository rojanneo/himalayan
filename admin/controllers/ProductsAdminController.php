<?php
class ProductsAdminController extends Controller
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
		$this->view->renderAdmin('products/grid.phtml');
	}

	public function addAction()
	{
		loadHelper('inputs');
		$productModel = getModel('products');
		$type = getParam('type');
		$set = getParam('set');
		if($type == false and $set == false)
		{
			$types = $productModel->getAvailableProductTypes();
			$data['types'] = $types;
			$sets = getModel('Attributeset')->getAllAttributeSets();
			$data['sets'] = $sets;
			$this->view->renderAdmin('products/selectType.phtml',$data);
		}
		else
		{
			$attributes = getModel('attribute')->getAttributeCollection($set);
			$data['type'] = $type;
			$data['set'] = $set;
			$data['attributes'] = $attributes;
			$this->view->renderAdmin('products/new.phtml',$data);
		}
	}
}