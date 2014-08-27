<?php
class WidgetsAdminController extends Controller
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

		$data['widgetlist']=getModel('widgets')->getWidgets();
		$this->view->renderAdmin('widgets/widgets_view.phtml',$data);
	}

	public function addnewWidgetsAction()
	{		

		$this->view->renderAdmin('widgets/new.phtml');
	}

	public function addWidgetpostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('widgets')->addWidgetpost($post_data))
		{
			redirect('admin/widgets');
		}
		else
		{
			
			$data['widget']['widget_name'] = $post_data['wname'];
			$data['widget']['widget_title']=$post_data['wtitle'];
			$data['widget']['wcontent']=$post_data['wcontent'];
			$data['widget']['widget_identifier']=$post_data['widentifier'];
			$data['false']='Already exsit indentifier. Try unique identofier';
			$this->view->renderAdmin('widgets/new.phtml',$data);
		}
	}

	public function editWidgetAction($attribute_id)
	{

		$widget = getModel('widgets')->getWidgetById($attribute_id);	
		$data['widget'] = $widget[0];
		if(!empty($data['widget'] ))
		{ 
			$this->view->renderAdmin('widgets/new.phtml',$data);
		}
		else 
		{
			var_dump($data['widget'] ); die();
		}
		
	}

	public function editWidgetpostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();		
		if(getModel('widgets')->updateWidget($post_data))
		{
			redirect('admin/widgets');
		}
		else
		{
			redirect('admin/widgets/addnewWidgets');
		}	
	}

	public function deleteWidgetAction($w_id)
	{
		if(getModel('widgets')->deleteWidgetPost($w_id))
		{
			redirect('admin/widgets');
		}
		else
		{
			redirect('admin/widgets/addnewWidgets');
		}
	}

	
	



}