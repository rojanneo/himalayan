<?php
require_once('system/recaptchalib.php');
class TestimonialsController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function indexAction()
	{
		$this->view->render('testimonials/form.phtml');
	}

	public function testimonialPostAction()
	{
		loadHelper('inputs');
		loadHelper('url');
		$post_data = getPost();
		$response_field = getPost("recaptcha_response_field");
		$recaptcha_challenge = getPost("recaptcha_challenge_field");
	 	$resp = recaptcha_check_answer (CAPTCHA_PRIVATE_KEY,
                                        $_SERVER["REMOTE_ADDR"],
                                        $recaptcha_challenge,
                                        $response_field);
	 	if($resp->is_valid)
	 	{
	 		getModel('testimonials')->saveTestimonial($post_data);
	 		redirect('testimonials');
	 	}
	 	else
	 	{
	 		redirect('testimonials');
	 	}
	}

	public function showAction()
	{
		loadHelper('inputs');
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 5;
		$first = ($page-1) * $limit;
		$testimonials = getModel('testimonials')->getTestimonials($first, $limit);
		$data['testimonials'] = $testimonials;
		$count = getModel('testimonials')->getTestimonialsCount()[0];
		$data['pagination_num'] = ceil($count["COUNT(*)"]/$limit);
		$this->view->render('testimonials/list.phtml',$data);
	} 
}
