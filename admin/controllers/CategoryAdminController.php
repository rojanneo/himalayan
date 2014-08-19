<?php
class CategoryAdminController extends Controller
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
		$model=getModel('category');
		$data['catagoryval']=$cat=$model->cat_hierarchy();
		$this->view->renderAdmin('categories/category.phtml',$data);
	}

	public function addnewAction()
	{
		$model=getModel('category');
		$data['catlist']=$model->getCategories();
		$this->view->renderAdmin('categories/new.phtml',$data);
	}

	public function addcatpostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('category')->addNewcategory($post_data))
		{
			redirect('admin/category');
		}
		else
		{
			redirect('admin/category/addnew');
		}
	}

	public function editcatAction($attribute_id)
	{
		$model=getModel('category');
		$data['catlist']=$model->getCategories();
		$category = getModel('category')->getCategoryById($attribute_id);		
		$data['category'] = $category[0];
		if(!empty($data['category'] ))
		{ 
			$this->view->renderAdmin('categories/new.phtml',$data);
		}
		else 
		{
			var_dump($data['category'] ); die();
		}
		
	}

	public function editcatpostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();		
		if(getModel('category')->updatecatval($post_data))
		{
			redirect('admin/category');
		}
		else
		{
			redirect('admin/category/addnew');
		}	
	}

	public function deletecatAction($category_id)
	{
		$model=getModel('category');
		if(getModel('category')->deletecatval($category_id))
		{
			redirect('admin/category');
		}
		else
		{
			redirect('admin/category/addnew');
		}
	}


}