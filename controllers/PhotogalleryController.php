<?php

class PhotogalleryController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function indexAction()
	{
		$photos = getModel('photogallery')->getAllActiveImages();
		$data['photos'] = $photos;
		$this->view->render('photogallery/slider.phtml',$data);
	}
}