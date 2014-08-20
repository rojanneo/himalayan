<?php
class FAQAdminController extends Controller
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
		$faqs = getModel('faq')->getAllFaqs();
		$data['faqs'] = $faqs;

		$this->view->renderAdmin('faqs/grid.phtml',$data);
	}

	public function addAction()
	{
		$this->view->renderAdmin('faqs/new.phtml');
	}

	public function addPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		//var_dump($post_data);die;
		if(getModel('faq')->addFaq($post_data))
		{
			redirect('admin/faq');
		}
		else
		{
			redirect('admin/faq/add');
		}
	}

	public function editAction($id)
	{
		$faq = getModel('faq')->loadFaq($id);
		$data['faq'] = $faq[0];

		$this->view->renderAdmin('faqs/new.phtml',$data);
	}

	public function editPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		//var_dump($post_data);die;
		if(getModel('faq')->updateFaq($post_data))
		{
			redirect('admin/faq');
		}
		else
		{
			redirect('admin/faq/edit'.$post_data['faq_id']);
		}
	}

	public function deleteAction($id)
	{
		getModel('faq')->deleteFaq($id);
		redirect('admin/faq');
	}
}