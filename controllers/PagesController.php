<?php

class PagesController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function viewAction($urlKey)
	{
		$model = getModel('pages');
		$page = $model->loadPage($urlKey);
		if(!$page) $this->view->render('default/404.phtml');
		else
		{
			$data['page'] = $page[0];
			$this->view->render('pages/pages.phtml',$data);
		}
	}

	public function privacyPolicyAction()
	{
		$this->view->render('pages/privacy-policy.phtml');
	}

	public function webusageAction()
	{
		$this->view->render('pages/webusage.phtml');		
	}
	
	public function endPiecesAction()
	{
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$ref = $_SERVER['HTTP_REFERER'];
			$id = explode('/',$ref);
			$data['url'] = $id[count($id)-1];
		}
		else
		$data['url'] = '15';
		$this->view->render('pages/end-pieces.phtml',$data);
	}

	public function microwaveAction()
	{
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$ref = $_SERVER['HTTP_REFERER'];
			$id = explode('/',$ref);
			$data['url'] = $id[count($id)-1];
		}
		else
		$data['url'] = '3';
		$this->view->render('pages/end-pieces.phtml',$data);
	}

	// public function homeAction()
	// {
	// 	$model = getModel('home');
	// 	$blogs = $model->getWhatOthersSay('blog');
	// 	$discussions = $model->getWhatOthersSay('disc');
	// 	$videos = $model->getWhatOthersSay('video');
	// 	$events = $model->getUpcomingEvents();
	// 	$data['blogs'] = $blogs;
	// 	$data['discussions'] = $discussions;
	// 	$data['videos'] = $videos;
	// 	$data['events'] = $events;
	// 	$this->view->render('home.phtml', $data);
	// }
}