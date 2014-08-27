<?php
class PagesAdminController extends Controller
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
		$pages = getModel('pages')->getPages($first,$limit);
		$data['pages'] = $pages;
		$data['pagination_num'] = ceil(getModel('pages')->getPagesCount()/$limit);
		$this->view->renderAdmin('pages/grid.phtml', $data);
	}

	public function editAction($page_id)
	{
		$page = getModel('pages')->getPageById($page_id);
		$data['page'] = $page;
		$this->view->renderAdmin('pages/new.phtml',$data);
	}

	public function addAction()
	{
		$this->view->renderAdmin('pages/new.phtml');
	}

	public function addPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('pages')->addNewPage($post_data))
		{
			redirect('admin/pages');
		}
		else
		{
			redirect('admin/pages/add');
		}
	}

	public function editPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('pages')->updatePage($post_data))
		{
			redirect('admin/pages');
		}
		else
		{
			redirect('admin/pages/edit/'.$post_data['page_id']);
		}
	}
}