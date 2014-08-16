<?php
class AttributeSetAdminController extends Controller
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
		$attributeSets = getModel('attributeset')->getAllAttributeSets();
		$data['attribute_set'] = $attributeSets;
		$this->view->renderAdmin('attributeset/grid.phtml',$data);
	}

	public function addAction()
	{
		$this->view->renderAdmin('attributeset/new.phtml');
	}

	public function editAction($attribute_set)
	{
		$attributeSet = getModel('attributeset')->getAttributeSetById($attribute_set);
		$data['attribute_set'] = $attributeSet[0];
		$attributes = getModel('attribute')->getAttributeCollection($attribute_set);
		$a = array();
		foreach($attributes as $attribute)
		{
			array_push($a, $attribute['aid']);
		}
		$data['attributes'] = $a;
		$this->view->renderAdmin('attributeset/new.phtml',$data);
	}

	public function editPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('attributeset')->updateAttributeset($post_data))
		{
			redirect('admin/attributeset');
		}
		else
		{
			redirect('admin/attributeset/edit/'.$post_data['attribute_set_id']);
		}
	}

	public function addPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('attributeset')->addNewAttributeset($post_data))
		{
			redirect('admin/attributeset');
		}
		else
		{
			redirect('admin/attributeset/add');
		}
	}
}