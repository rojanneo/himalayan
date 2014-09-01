<?php
class HomeController extends Controller
{
public function __construct()
{
	parent::__construct();
	// loadHelper('url'); 
	// redirect('pages/view/our-mission');
	
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
	$data['blogpost']=$model->getBlogPosts();
	$this->view->render('home/home.phtml', $data);

}

public function blogAction($attribute_val)
{

	$data['post']=getModel('home')->getBlogByVal($attribute_val);
	$this->view->render('home/post.phtml',$data);
}

}