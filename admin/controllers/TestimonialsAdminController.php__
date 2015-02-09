<?php 
class TestimonialsAdminController extends Controller
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
		$limit = 20;
		$first = ($page-1) * $limit;
		$testimonials = getModel('testimonials')->getTestimonials($first,$limit);
		$data['testimonials'] = $testimonials;
		$data['pagination_num'] = ceil(getModel('testimonials')->getTestimonialsCount()/$limit);
		$this->view->renderAdmin('testimonials/grid.phtml', $data);
	}

	public function deleteAction($id)
	{
		if(getModel('testimonials')->deleteTestimonial($id))
		{
			AdminSession::addSuccessMessage('Testimonial Deleted');
		}
		else
		{
			AdminSession::addErrorMessage('Testimonial Could Not Be Deleted');			
		}
		loadHelper('url');
		redirect('admin/testimonials');
	}

	public function viewAction($id)
	{
		$testimonial = getModel('testimonials')->getTestimonial($id);
		$data['testimonial'] = $testimonial;
		$this->view->renderAdmin('testimonials/view.phtml',$data);
	}
}