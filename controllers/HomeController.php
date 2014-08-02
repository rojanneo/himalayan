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
$data['test'] = 'test';
$this->view->render('home.phtml', $data);
}

}