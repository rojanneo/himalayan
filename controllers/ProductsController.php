<?php

class ProductsController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		loadHelper('url');
	}

	public function categoriesAction()
	{
		$model = getModel('category');
		$categories = $model->getCategoryBySlug('our-creations');
		$data['category'] = $categories;
		$this->view->render('products/categories.phtml', $data);
	}

	public function listAction($category_id = null)
	{
		//MAKE THIS DYNAMIC
		if($category_id == 21)
		header('Location: http://www.leanlix.com/');
		else
		{
		$products = getModel('products')->getProductsFromCategoryId($category_id);
		$data['products'] = $products;
		$data['category_id'] = $category_id;
		$category = getModel('category')->getCategoryById($category_id);
		$data['category'] = $category[0];
		$this->view->render('products/list.phtml',$data);
		}
	}

}