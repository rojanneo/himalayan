<?php

class FaqModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAllFaqs()
	{
		$query = "SELECT * FROM faq";
		$faqs = $this->connection->Query($query);
		return $faqs;
	}

	public function loadFaq($faq_id)
	{
		$query = "SELECT * FROM faq WHERE faq_id='".$faq_id."'";
		$faq = $this->connection->Query($query);
		return $faq;
	}

	public function searchFaq($keywords)
	{
		$results = array();
		foreach($keywords as $keyword => $key)
		{
			$query = "SELECT * FROM faq WHERE MATCH (faq_question,faq_answer) AGAINST ('+".$keyword."' IN BOOLEAN MODE)";
			$faqs = $this->connection->Query($query);
			foreach($faqs as $faq)
			{
				$results[$faq['faq_id']] = $faq;
			}
		}
		return $results;
	}
}