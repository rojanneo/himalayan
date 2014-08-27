<?php
class ConfigurationAdminController extends Controller
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
		$fields = getModel('configuration')->getFieldsOrderedByGroup();
		$data['groups'] = $fields;
		$this->view->renderAdmin('configurations/fields.phtml', $data);
	}

	public function saveConfigAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('configuration')->saveConfigData($post_data))
		{
			redirect('admin/configuration');
		}
		else
		{
			redirect('admin/configuration');
		}
	}

	public function groupListAction()
	{
		loadHelper('inputs');
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 10;
		$first = ($page-1) * $limit;
		$data['groups'] = getModel('Configuration')->getConfigGroups($first,$limit);

		$data['pagination_num'] = ceil(getModel('Configuration')->getConfigGroupsCount()/$limit);

		$this->view->renderAdmin('configurations/groups_list.phtml',$data);
	}

	public function addGroupAction()
	{
		$this->view->renderAdmin('configurations/addGroup.phtml');
	}

	public function editGroupAction($group_id)
	{
		$data['group'] = getModel('configuration')->getConfigGroupById($group_id);
		$this->view->renderAdmin('configurations/addGroup.phtml', $data);

	}

	public function addGroupPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('Configuration')->addConfigGroup($post_data))
		{
			redirect('admin/configuration/grouplist');
		}
		else
		{
			redirect('admin/configuration/addgroup');
		}
	}

	public function editGroupPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('Configuration')->updateConfigGroup($post_data))
		{
			redirect('admin/configuration/grouplist');
		}
		else
		{
			redirect('admin/configuration/addgroup');
		}
	}

	public function deleteGroupAction($id)
	{
		if(getModel('Configuration')->deleteConfigGroup($id))
		{
			redirect('admin/configuration/grouplist');
		}
	}

	public function fieldListAction()
	{
		loadHelper('inputs');
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 10;
		$first = ($page-1) * $limit;
		$fields = getModel('configuration')->getConfigFields($first,$limit);
		$data['fields'] = $fields;

		$data['pagination_num'] = ceil(getModel('Configuration')->getConfigFieldsCount()/$limit);
		$this->view->renderAdmin('configurations/fieldlist.phtml', $data);
	}

	public function addFieldAction()
	{
		$groups = getModel('configuration')->getConfigGroups();
		$data['groups'] = $groups;
		$this->view->renderAdmin('configurations/addfield.phtml', $data);

	}

	public function editFieldAction($field_id)
	{
		$data['field'] = getModel('configuration')->getConfigFieldById($field_id);
		$groups = getModel('configuration')->getConfigGroups();
		$data['groups'] = $groups;
		$this->view->renderAdmin('configurations/addfield.phtml', $data);

	}

	public function addFieldPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('Configuration')->addConfigField($post_data))
		{
			redirect('admin/configuration/fieldlist');
		}
		else
		{
			redirect('admin/configuration/addfield');
		}
	}

	public function editFieldPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('Configuration')->updateConfigField($post_data))
		{
			redirect('admin/configuration/fieldlist');
		}
		else
		{
			redirect('admin/configuration/addfield');
		}

	}

	public function deleteFieldAction($id)
	{
		if(getModel('Configuration')->deleteField($id))
		{
			redirect('admin/configuration/fieldlist');
		}
	}
}