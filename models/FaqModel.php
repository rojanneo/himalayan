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

	public function addFaq($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$query = "INSERT INTO `faq`(`faq_question`, `faq_answer`) VALUES ('$faq_question','$faq_answer')";
		return $this->connection->InsertQuery($query);
	}

	public function updateFaq($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$query = "UPDATE `faq` SET `faq_question`='$faq_question',`faq_answer`='$faq_answer' WHERE `faq_id` = $faq_id";
		return $this->connection->UpdateQuery($query);
	}

	public function deleteFaq($id)
	{
		$sql = "DELETE FROM `faq` WHERE `faq_id` = ".$id;
		return $this->connection->DeleteQuery($sql);
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