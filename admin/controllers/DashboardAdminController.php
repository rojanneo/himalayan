<?php
require_once('system/ImageManipulator.php');
class DashboardAdminController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function indexAction()
	{
		echo 'admin dashboard';
		//echo file_get_contents('http://192.168.1.107/himalayan/assets/uploads/photogallery/vito.jpg');

		$im = new ImageManipulator(file_get_contents('http://192.168.1.107/himalayan/assets/uploads/photogallery/elle.jpg'));
		$centreX = round($im->getWidth() / 2);
		$centreY = round($im->getHeight() / 2);

		$x1 = $centreX - 100;
		$y1 = $centreY - 100;

		$x2 = $centreX + 100;
		$y2 = $centreY + 100;

		$im->crop($x1, $y1, $x2, $y2); // takes care of out of boundary conditions automatically
		$im->save('assets/uploads/photogallery/cropped/elle.jpg');

	}

	public function testAction()
	{
		$this->view->renderAdmin('admin/test.phtml');
	}


	public function modelAction()
	{
		var_dump(getModel('category')->getCategories());
	}
}