<?php
require_once 'system/controller.php';
class HomeController extends Controller
{
public function __construct()
{
	parent::__construct();
	
}

public function homeAction()
{

	$model = getModel('home');
	$blogs = $model->getWhatOthersSay('blog');
	$discussions = $model->getWhatOthersSay('disc');
	$videos = $model->getWhatOthersSay('video');
	$events = $model->getUpcomingEvents();
	$data['blogs'] = $blogs;
	$data['discussions'] = $discussions;
	$data['videos'] = $videos;
	$data['events'] = $events;
	$this->view->render('home.phtml', $data);

}

}