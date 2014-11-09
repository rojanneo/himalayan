<?php
class TestimonialsModel extends Model
{
	public function __construt()
	{
		parent::__cosntruct();
	}

	public function saveTestimonial($post_data)
	{
		extract($post_data);
		$query = "Insert into testimonial_new(testimonial_date,testimonial_name,testimonial_email,testimonial_address,testimonial,testimonial_rating,testimonial_helpful_count, testimonial_not_helpful_count) values('".$t_dt."','".$t_name."','".$t_email."',
			'".$t_add."','".$t_comment."', '".$rate_val."', 0, 0)";
		$this->connection->InsertQuery($query);
	}

	public function getTestimonials($first, $limit)
	{
		$query = 'SELECT * FROM testimonial_new ORDER BY testimonial_id DESC Limit '.$first.','.$limit;
		$testimonials = $this->connection->Query($query);
		return $testimonials;

	}

	public function getAllTestimonials()
	{
		$query = 'SELECT * FROM testimonial_new ORDER BY testimonial_id DESC';
		$testimonials = $this->connection->Query($query);
		return $testimonials;		
	}

	public function searchTestimonials($keywords)
	{
		$results = array();
		foreach($keywords as $keyword => $key)
		{
			$query = "SELECT * FROM testimonial_new WHERE MATCH (testimonial) AGAINST ('+".$keyword."' IN BOOLEAN MODE)";
			$testimonials = $this->connection->Query($query);
			foreach($testimonials as $testimonial)
			{
				$results[$testimonial['testimonial_id']] = $testimonial;
			}
		}
		return $results;
	}

	public function getTestimonialsCount()
	{
		$query = 'SELECT COUNT(*) FROM testimonials;';
		$count = $this->connection->Query($query);
		return $count[0]['COUNT(*)'];
	}

	public function deleteTestimonial($id)
	{
		$sql = "DELETE FROM testimonial_new WHERE testimonial_id = $id";
		$result1 = $this->connection->DeleteQuery($sql);
		$sql = "DELETE FROM testimonial_comment WHERE comment_testimonial_id = $id";
		$result2 = $this->connection->DeleteQuery($sql);
		return $result1 and $result2;
	}

	public function getTestimonial($id)
	{
		$sql = "SELECT * FROM testimonial_new WHERE testimonial_id = $id";
		$t = $this->connection->Query($sql);
		return $t[0];
	}

	public function getComment($id)
	{
		$sql = "SELECT * FROM testimonial_comment WHERE comment_id = $id";
		$comment = $this->connection->Query($sql);
		if($comment) return $comment[0];
		else return false;
	}

	public function addComment($post_data)
	{
		if($post_data) extract($post_data);
		//$sql = "INSERT INTO `testimonial_comment`(`comment_testimonial_id`, `comment_from`, `comment_message`) 
		//VALUES ($comment_testimonial_id,'$comment_from','".mysql_escape_string($comment_message)."')";
		$now = new DateTime();
		$now=$now->format('Y-m-d H:i:s');
		if(empty($comment_parent))
		{
			$sql="INSERT INTO `comment`(`comment_post_ID`, `comment_date`, `comment_content`, `comment_approved`, `comment_parent`, `user_id`, `comment_category`)
		 VALUES ('$comment_testimonial_id','$now','".mysql_escape_string($comment_message)."','1','0','$user_id','tes')";
		}
		else
		{
			$sql="INSERT INTO `comment`(`comment_post_ID`, `comment_date`, `comment_content`, `comment_approved`, `comment_parent`, `user_id`, `comment_category`)
		 VALUES ('$comment_testimonial_id','$now','".mysql_escape_string($comment_message)."','1','$comment_parent','$user_id','tes')";
		}
		var_dump($sql);
		$result = $this->connection->InsertQuery($sql);
		if($result) return $this->connection->GetInsertID();
		else return false;
	}

	public function makeHelpful($id)
	{
		$testimonial = $this->getTestimonial($id);
		$count = ++$testimonial['testimonial_helpful_count'];
		$sql = "UPDATE `testimonial_new` SET `testimonial_helpful_count`=$count WHERE `testimonial_id` = $id";
		return $this->connection->UpdateQuery($sql);
	}

	public function notHelpful($id)
	{
		$testimonial = $this->getTestimonial($id);
		$count = ++$testimonial['testimonial_not_helpful_count'];
		$sql = "UPDATE `testimonial_new` SET `testimonial_not_helpful_count`=$count WHERE `testimonial_id` = $id";
		return $this->connection->UpdateQuery($sql);
	}


	public function getTestimonialComments($testimonial_id)
	{
		/*$sql = "SELECT `comment_id`, `comment_testimonial_id`, `comment_from`, `comment_message` FROM `testimonial_comment` WHERE `comment_testimonial_id` = $testimonial_id ORDER BY comment_id ASC";
		$comments = $this->connection->Query($sql);
		if($comments)
		return $comments;
		else return false; */
		$sql="SELECT `comment_ID`, `comment_post_ID`, `user_id`, `comment_content`,`comment_date` FROM `comment` WHERE `comment_post_ID` = '$testimonial_id' AND `comment_parent`='0' AND `comment_category`='tes' ORDER BY comment_ID ASC";
		$comments = $this->connection->Query($sql);
		$comentval=$comments;
		/*if($comments)
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
         return $comments_html; 
         */
        if($comments) return $comments;
         else return false;
	}



	public function deleteComment($id)
	{
		$sql = "DELETE FROM `testimonial_comment` WHERE comment_id=$id";
		return $this->connection->DeleteQuery($sql);
	}


	public function gettesComments($comment_post_id)
	{
		$sql="SELECT `comment_ID`, `comment_post_ID`, `user_id`, `comment_content`,`comment_date` FROM `comment` WHERE `comment_post_ID` = '$comment_post_id' AND `comment_parent`='0' AND `comment_category`='tes' ORDER BY comment_ID ASC";
		$comments = $this->connection->Query($sql);
		$comentval=$comments;	
		if($comments)
		{
			
			$comments_html='<ul>';
			foreach ($comments as $comments)
			{
				$comments_html.=$this->commentloop($comments['comment_post_ID'],'tes',$comments['comment_ID'],$comments['comment_content'],$comments['user_id'],$comments['comment_date']);
			}
			$comments_html.='</ul>';
							
			}	
			else
			{
				return false;
			}
         return $comments_html;
		
		
	}

	public function commentloop($comment_post_ID,$faq,$comment_ID,$comment_content,$user,$date)
	{
			$usersql="SELECT * FROM `members` WHERE `mid` = '$user'";
			$usersqlval=$this->connection->Query($usersql);
			$newDate = date('m/d/y', strtotime($date));

			$session = Session::getCurrentSession();  $role = getModel('customer')->getCustomerRole($session['user_id']);
			if(!isset($role))
			{
			$comments_html='<div class="comment_user"><div class="innercomment"><p class="2"><span>'.$comment_content.'</span> -'.$usersqlval[0]['mname'].' from '.$usersqlval[0]['mcity'].', '.$usersqlval[0]['mstate'].'  | '.$newDate.'</p></div>';
			$comments_html.='<div class="actions">                                    
                                     <div class="helpfulornot">
                                     <input type="hidden" name="tes_id_actions" value="'.$comment_post_ID.'"/>  
                                     <input type="hidden" name="tes_id_actions_parent" value="'.$comment_ID.'"/>                                      
                                    </div>
            </div>';
			}
			else
			{
			$comments_html='<div class="comment_user"><div class="innercomment"><p class="2"><span>'.$comment_content.'</span> -'.$usersqlval[0]['mname'].' from '.$usersqlval[0]['mcity'].', '.$usersqlval[0]['mstate'].'  | '.$newDate.'</p></div>';
			$comments_html.='<div class="actions">
                                    <a href="javascript:void(0)" class="reply-comment-link1">reply with quote</a>
                                    <a href="javascript:;"> | </a>
                                    <a href="javascript:void(0)" class="comment-link1" onclick="commentlink1(this)">comment</a>
                                     <div class="helpfulornot">
                                     <input type="hidden" name="tes_id_actions" value="'.$comment_post_ID.'"/>  
                                     <input type="hidden" name="tes_id_actions_parent" value="'.$comment_ID.'"/>                                      
                                    </div>
            </div>';
        	}
            $comments_html.='</div>';

			$sql="SELECT `comment_ID`, `comment_post_ID`, `user_id`, `comment_content`,`comment_date` FROM `comment` WHERE `comment_post_ID` = '$comment_post_ID' AND `comment_parent`='$comment_ID' AND `comment_category`='tes' ORDER BY comment_ID ASC";
			$comments = $this->connection->Query($sql);	
			if($comments)
			{
				$comments_html.='<ul>';
				foreach ($comments as $comments) 
				{
				if ($user==0) {
					$comments_html.=$this->commentloop($comments['comment_post_ID'],'tes',$comments['comment_ID'],$comments['comment_content'],0,$comments['comment_date']);
					
							}			
					
					else{
					$comments_html.=$this->commentloop($comments['comment_post_ID'],'tes',$comments['comment_ID'],$comments['comment_content'],$comments['user_id'],$comments['comment_date']);
						}
				}
				$comments_html.='</ul>';
			}
		return $comments_html;	

	}
	public function getTestimonialCommentsnew($comment_post_id,$comment_parent)
	{
		$sql="SELECT `comment_ID`, `comment_post_ID`, `user_id`, `comment_content`,`comment_date` FROM `comment` WHERE `comment_post_ID` = '$comment_post_id' AND `comment_parent`='$comment_parent' AND `comment_category`='tes' ORDER BY comment_ID ASC";
		$comments = $this->connection->Query($sql);
		if($comments) return $comments;
		else return $comments;

	}

	public function findusertes($user)
	{
		$usersql="SELECT * FROM `members` WHERE `mid` = '$user'";
		$usersqlval=$this->connection->Query($usersql);
		if($usersqlval) return $usersqlval;
		else return $usersqlval;

	}





}