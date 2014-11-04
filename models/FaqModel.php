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
		if($faq)		return $faq;
		else return false;
	}

	public function addFaq($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$faq_question = mysql_escape_string($faq_question);
		$faq_answer = mysql_escape_string($faq_answer);
		$query = "INSERT INTO `faq`(`faq_question`, `faq_answer`) VALUES ('$faq_question','$faq_answer')";
		return $this->connection->InsertQuery($query);
	}

	public function updateFaq($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$faq_question = mysql_escape_string($faq_question);
		$faq_answer = mysql_escape_string($faq_answer);
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

	public function getFaqs($first,$limit)
	{
		$sql = "SELECT * FROM faq ORDER BY faq_id LIMIT $first,$limit";
		return $this->connection->Query($sql);
	}

	public function getFaqCount()
	{
		$sql = "SELECT * FROM faq";
		return count($this->connection->Query($sql));
	}

	public function getfaq($id)
	{
		$sql = "SELECT * FROM faq WHERE faq_id = $id";
		$t = $this->connection->Query($sql);
		return $t[0];
	}

	public function makeHelpful($id)
	{
		$faq = $this->getfaq($id);
		$count = ++$faq['faq_helpful_count'];
		$sql = "UPDATE `faq` SET `faq_helpful_count`=$count WHERE `faq_id` = $id";
		return $this->connection->UpdateQuery($sql);
	}

	public function notHelpful($id)
	{
		$faq = $this->getfaq($id);
		$count = ++$faq['faq_not_helpful_count'];
		$sql = "UPDATE `faq` SET `faq_not_helpful_count`=$count WHERE `faq_id` = $id";
		return $this->connection->UpdateQuery($sql);
	}

	public function addComment($post_data)
	{

		if($post_data) extract($post_data);
		$now = new DateTime();
		$now=$now->format('Y-m-d H:i:s');
		if(empty($comment_parent))
		{
			$sql="INSERT INTO `comment`(`comment_post_ID`, `comment_date`, `comment_content`, `comment_approved`, `comment_parent`, `user_id`, `comment_category`)
		 VALUES ('$comment_post_ID','$now','".mysql_escape_string($comment_content)."','1','0','$user_id','faq')";
		}
		else
		{
			$sql="INSERT INTO `comment`(`comment_post_ID`, `comment_date`, `comment_content`, `comment_approved`, `comment_parent`, `user_id`, `comment_category`)
		 VALUES ('$comment_post_ID','$now','".mysql_escape_string($comment_content)."','1','$comment_parent','$user_id','faq')";
		}
		/*$sql = "INSERT INTO `comment`(`comment_post_ID`,`comment_date`,`comment_content`,`comment_approved`,`comment_parent`,`user_id`,`comment_category`) 
		VALUES ($comment_post_ID,$now,'".mysql_escape_string($comment_content)."','1','0',$user_id','faq'";

			*/
		/*$sql=INSERT INTO `comment`(`comment_post_ID`, `comment_date`, `comment_content`, `comment_approved`, `comment_parent`, `user_id`, `comment_category`)
		 VALUES ('24','2014-10-20 00:00:00','asdfajh','1','0','3951','faq');
		 */

		$result = $this->connection->InsertQuery($sql);
		if($result) return $this->connection->GetInsertID();
		else return false;
	}

	public function getfaqComments($comment_post_id)
	{
		/*$sql = "SELECT `comment_ID`, `comment_post_ID`, `user_id`, `comment_content` FROM `comment` WHERE `comment_post_ID` = '$comment_post_id' ORDER BY comment_ID ASC";
		$comments = $this->connection->Query($sql);
		if($comments)
		return $comments;
		else return false;*/

		//$comments=getModel('comment')->get_comment($comment_post_id,'faq','0');
		$sql="SELECT `comment_ID`, `comment_post_ID`, `user_id`, `comment_content`,`comment_date` FROM `comment` WHERE `comment_post_ID` = '$comment_post_id' AND `comment_parent`='0' AND `comment_category`='faq' ORDER BY comment_ID ASC";
		$comments = $this->connection->Query($sql);
		$comentval=$comments;
		/*$sql="SELECT `comment_ID`, `comment_post_ID`, `user_id`, `comment_content` FROM `comment` WHERE `comment_post_ID` = '$comment_post_id' AND `comment_parent`='0' AND `comment_category`='faq' ORDER BY comment_ID ASC";
		$comments = $this->connection->Query($sql);	*/	
		if($comments)
		{
			
			$comments_html='<ul>';
			foreach ($comments as $comments)
			{
				$comments_html.=$this->commentloop($comments['comment_post_ID'],'faq',$comments['comment_ID'],$comments['comment_content'],$comments['user_id'],$comments['comment_date']);
			}
			$comments_html.='</ul>';
							
			}	
			else
			{
				return false;
			}

		//return $comentval;
         return $comments_html;
		
		
	}

	public function commentloop($comment_post_ID,$faq,$comment_ID,$comment_content,$user,$date)
	{
			$session = Session::getCurrentSession();
            $role = getModel('customer')->getCustomerRole($session['user_id']);
			$usersql="SELECT * FROM `members` WHERE `mid` = '$user'";
			$usersqlval=$this->connection->Query($usersql);
			$newDate = date('m/d/y', strtotime($date));

			$comments_html='<li class="comment_hdc">'.$comment_content.' -'.$usersqlval[0]['mname'].' from '.$usersqlval[0]['mcity'].', '.$usersqlval[0]['mstate'].'  | '.$newDate.'</li>';
			if(isset($role))
			{
				$comments_html.='<div class="actions">
                                    <a href="javascript:void(0)" class="reply-comment-link1">reply with quote</a>
                                    <a href="javascript:;"> | </a>
                                    <a href="javascript:void(0)" class="comment-link1">comment</a>
                                     <div class="helpfulornot">
                                     <input type="hidden" name="faq_id_actions" value="'.$comment_post_ID.'"/>  
                                     <input type="hidden" name="faq_id_actions_parent" value="'.$comment_ID.'"/>                                      
                                    </div>
            </div>';
			}
			{
			$comments_html.='<div class="actions">
                                  
                                     <div class="helpfulornot">
                                     <input type="hidden" name="faq_id_actions" value="'.$comment_post_ID.'"/>  
                                     <input type="hidden" name="faq_id_actions_parent" value="'.$comment_ID.'"/>                                      
                                    </div>
            </div>';
        	}

			$sql="SELECT `comment_ID`, `comment_post_ID`, `user_id`, `comment_content`,`comment_date` FROM `comment` WHERE `comment_post_ID` = '$comment_post_ID' AND `comment_parent`='$comment_ID' AND `comment_category`='faq' ORDER BY comment_ID ASC";
			$comments = $this->connection->Query($sql);	
			if($comments)
			{
				$comments_html.='<ul>';
				foreach ($comments as $comments) 
				{					
					$comments_html.=$this->commentloop($comments['comment_post_ID'],'faq',$comments['comment_ID'],$comments['comment_content'],$comments['user_id'],$comments['comment_date']);
				}
				$comments_html.='</ul>';
			}
		return $comments_html;	

	}

	public function getComment($id)
	{
		$sql = "SELECT * FROM comment WHERE `comment_post_ID` = '$id'";
		$comment = $this->connection->Query($sql);
		if($comment) return $comment[0];
		else return false;
	}


}