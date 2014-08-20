<?php

class ProductsController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function categoriesAction()
	{
		$model = getModel('category');
		$categories = $model->getCategories();
		$data['categories'] = $categories;
		$this->view->render('products/categories.phtml', $data);
	}

	public function listAction($category_id = null)
	{
		//MAKE THIS DYNAMIC
		$data['category_id'] = $category_id;
		$this->view->render('products/list.phtml',$data);
	}

}