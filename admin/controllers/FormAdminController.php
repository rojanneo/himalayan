<?php 
class FormAdminController extends Controller
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

		loadHelper('inputs');
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 10;
		$first = ($page-1) * $limit;
		$faqs = getModel('form')->getForms($first,$limit);
		$data['pagination_num'] = ceil(getModel('form')->getFormCount()/$limit);
		$data['forms'] = getModel('form')->getAllForms();
		$this->view->renderAdmin('forms/grid.phtml',$data);
	}

	public function addAction()
	{
		$this->view->renderAdmin('forms/new.phtml');
	}

	public function addPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		getModel('form')->addNewForm($post_data);
		redirect('admin/form');
	}

	public function editAction($id)
	{
		$form = getModel('form')->getForm($id);
		$data['form'] = $form;
		$this->view->renderAdmin('forms/new.phtml',$data);
	}

	public function editPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		getModel('form')->updateForm($post_data);
		redirect('admin/form');
	}

	public function deleteAction($id)
	{
		getModel('form')->deleteForm($id);
		redirect('admin/form');
	}
}