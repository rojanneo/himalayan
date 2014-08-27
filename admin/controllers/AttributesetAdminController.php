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
		loadHelper('inputs');
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 10;
		$first = ($page-1) * $limit;
		$attributeSets = getModel('attributeset')->getAttributeSet($first,$limit);
		$data['attribute_set'] = $attributeSets;
		$data['pagination_num'] = ceil(getModel('attributeset')->getAttributeSetCount()/$limit);
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

	public function deleteAction($attributeset_id)
	{
		loadHelper('url');
		if(getModel('attributeset')->deleteAttributeset($attributeset_id))
		{
			AdminSession::addSuccessMessage('Attribute Set Deleted');
			redirect('admin/attributeset');
		}
		else
		{
			AdminSession::addErrorMessage('Could not delete Attribute Set');
			redirect('admin/attributeset/edit/'.$attributeset_id);
		}
	}
}