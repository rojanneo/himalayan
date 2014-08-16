<?php
class AttributesAdminController extends Controller
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
		$attributes = getModel('attribute')->getAllAttributes();
		$data['attributes'] = $attributes;
		$this->view->renderAdmin('attributes/grid.phtml', $data);
	}

	public function addAction()
	{
		$this->view->renderAdmin('attributes/new.phtml');
	}

	public function addPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('attribute')->addNewAttribute($post_data))
		{
			redirect('admin/attributes');
		}
		else
		{
			redirect('admin/attributes/add');
		}
	}

	public function editAction($attribute_id)
	{
		$attribute = getModel('attribute')->getAttributeById($attribute_id);
		$data['attribute'] = $attribute[0];
		$options = getModel('attribute')->getAttributeOptions($attribute_id);
		$data['options'] = $options;
		$this->view->renderAdmin('attributes/new.phtml',$data);
	}

	public function deleteAction($attribute_id)
	{
		loadHelper('url');
		if(getModel('attribute')->deleteAttribute($attribute_id))
		{
			AdminSession::addSuccessMessage('Attribute Deleted');
			redirect('admin/attributes');
		}
		else
		{
			AdminSession::addErrorMessage('Could not delete Attribute');
			redirect('admin/attributes/edit/'.$attribute_id);
		}
	}

	public function editPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('attribute')->updateAttribute($post_data))
		{
			redirect('admin/attributes');
		}
		else
		{
			redirect('admin/attributes/add');
		}	}
}