<?php

class FaqController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function indexAction()
	{
		// $text = "Although Himalayan Dog Chew rarely goes bad, please stop feeding the dog and call us immediately if you see fibrous white light or green blue spots on the chew. This is a sign of mold growth and is hazardous. We would appreciate these chews to be placed in a zipper bag and sent to us for testing. In replacement we can send you a replacement chew right away.";
		// $words = $this->extractCommonWords($text);
		// echo implode(',', array_keys($words));

		$faqs = getModel('faq')->getAllFaqs();
		$data['faqs'] = $faqs;
		$this->view->render('faq/faqs.phtml',$data);
	}

	public function viewAction($faq_id)
	{
		$faq = getModel('faq')->loadFaq($faq_id);
		$data['faq'] = $faq[0];
		$this->view->render('faq/view.phtml',$data);
	}

	public function searchAction()
	{
		loadHelper('inputs');
		//var_dump($_GET['faq-search-query']); die();
		//$query = getPost("faq-search-query");
		$query=$_GET['faq-search-query'];
		$keywords = $this->extractCommonWords($query);
		$results = getModel('faq')->searchFaq($keywords);
		if(!empty($query))
		{ 		
		$data['search_results'] = $results;		
		}
		else
		{ 
			loadHelper('url');
			//$data['nopostdata']=1;
			redirect('faq');
		}
		$faqs = getModel('faq')->getAllFaqs();
		$data['faqs'] = $faqs;
		$this->view->render('faq/faqs.phtml',$data);
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