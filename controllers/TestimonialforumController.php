<?php
require_once('system/recaptchalib.php');
class TestimonialforumController extends Controller
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
	 		Session::addSuccessMessage("Your Testimonial has been recorded.");
	 		redirect('testimonials');
	 	}
	 	else
	 	{
	 		Session::addErrorMessage("Your Testimonial could not be recorded.");
	 		redirect('testimonials');
	 	}
	}

	public function showAction()
	{
		loadHelper('inputs');
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 1;
		$first = ($page-1) * $limit;
		$testimonials = getModel('testimonials')->getAllTestimonials();
		$data['testimonials'] = $testimonials;
		$count = getModel('testimonials')->getTestimonialsCount();
		$data['pagination_num'] = ceil($count/$limit);
		$this->view->render('testimonials/list.phtml',$data);
	} 

	public function searchAction()
	{
		loadHelper('inputs');
		$query=getParam('testimonial_search_query');
		if($query != '')
		{
		$keywords = $this->extractCommonWords($query);
		$testimonials = getModel('testimonials')->searchTestimonials($keywords);
		$data['testimonials'] = $testimonials;
		$this->view->render('testimonials/list.phtml',$data);
		}
		else
		{
			loadHelper('url');
			redirect('testimonials/show');
		}

	}

	public function loadCommentsAction($id)
	{
		$comments = getModel('testimonials')->getTestimonialComments($id);
		$data['comments'] = $comments;
		$this->view->render('testimonials/comments.phtml', $data, false, false, false);
	}

	public function addCommentAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		$id = getModel('testimonials')->addComment($post_data);
		if($id)
		{
			$comment = getModel('testimonials')->getComment($id);
			print '<div class="comment_user">'.$comment['comment_message'].'</div>';
		}
	}

	public function makeHelpfulAction($id)
	{
		if(getModel('testimonials')->makeHelpful($id))
		{
			print 'true';
		}
		else
		{
			print 'false';
		}
	}
	public function notHelpfulAction($id)
	{
		if(getModel('testimonials')->notHelpful($id))
		{
			print 'true';
		}
		else
		{
			print 'false';
		}
	}

	private function extractCommonWords($string)
	{
      $stopWords = array('i','a','about','an','and','are','as','at','be','by','com','de','en','for','from','how','in','is','it','la','of','on','or','that','the','this','to','was','what','when','where','who','will','with','und','the','www');
   
      $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
      $string = trim($string); // trim the string
      $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
      $string = strtolower($string); // make it lowercase
   
      preg_match_all('/\b.*?\b/i', $string, $matchWords);
      $matchWords = $matchWords[0];
      
      foreach ( $matchWords as $key=>$item ) {
          if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
              unset($matchWords[$key]);
          }
      }   
      $wordCountArr = array();
      if ( is_array($matchWords) ) {
          foreach ( $matchWords as $key => $val ) {
              $val = strtolower($val);
              if ( isset($wordCountArr[$val]) ) {
                  $wordCountArr[$val]++;
              } else {
                  $wordCountArr[$val] = 1;
              }
          }
      }
      arsort($wordCountArr);
      $wordCountArr = array_slice($wordCountArr, 0, 10);
      return $wordCountArr;
	}
}