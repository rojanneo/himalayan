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
		$categories = $model->getCategoryBySlug('our-creations');
		$data['category'] = $categories;
		$this->view->render('products/categories.phtml', $data);
	}

	public function listAction($category_id = null)
	{
		//MAKE THIS DYNAMIC
		$products = getModel('products')->getProductsFromCategoryId($category_id);
		$data['products'] = $products;
		$data['category_id'] = $category_id;
		$category = getModel('category')->getCategoryById($category_id);
		$data['category'] = $category[0];
		$this->view->render('products/list.phtml',$data);
	}

}