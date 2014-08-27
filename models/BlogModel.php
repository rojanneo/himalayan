<?php

class BlogModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getBlogs($first, $limit)
	{
		$query = "SELECT * FROM blog ORDER BY blog_id DESC LIMIT $first, $limit";	
		return $this->connection->Query($query);
	}

	public function getBlogCount()
	{
		$query = "SELECT * FROM blog";
		return count($this->connection->Query($query));
	}
	public function getBlogById($attribute_id)
	{
		$query="SELECT * FROM `blog` WHERE `blog_id`='".$attribute_id."'";
		return $this->connection->Query($query);
	}

	public function addNewBlog($post_data)
	{
		if($post_data) extract($post_data);		
		$blog_name=str_replace(" ","_",$bname);
		$blog_guid=URL.$blog_name;
		$sqlbname="SELECT * FROM `blog` WHERE `blog_name`='".$blog_name."'";
		$sqlbnameexsit=$this->connection->Query($sqlbname);
		if(!empty($sqlbnameexsit))
		{			
			$blog_name=$blog_name.uniqid();
			$sql="INSERT INTO `blog`(`blog_title`, `blog_content`, `blog_status`, `blog_guid`, `blog_name`,`blog_feature_image`) VALUES ('".$bname."','".$bcontent."','".$bstatus."','".$blog_guid."','".$blog_name."','".$bfimage."')";
			return $this->connection->InsertQuery($sql);
		
		}
		else
		{			
		$sql="INSERT INTO `blog`(`blog_title`, `blog_content`, `blog_status`, `blog_guid`, `blog_name`,`blog_feature_image`) VALUES ('".$bname."','".$bcontent."','".$bstatus."','".$blog_guid."','".$blog_name."','".$bfimage."')";
		return $this->connection->InsertQuery($sql);	
		}
	}

	public function updateblog($post_data)
	{
		$now=date('Y-m-d H:i:s'); 
		if($post_data) extract($post_data);		
		$date=$bpublish.' '.date('H:i:s');		
		$sql="UPDATE `blog` SET `blog_title`='".$bname."',`blog_content`='".$bcontent."',`blog_status`='".$bstatus."',`blog-published_date`='".$date."',`blog_revised_date`='".$now."',`blog_feature_image`='".$bfimage."' WHERE `blog_id`='".$blog_id."'";
			
		return $this->connection->UpdateQuery($sql);
	}

	public function deleteBlogPost($blog_id)
	{ 
		//var_dump($blog_id); die();
		$sql="DELETE FROM `blog` WHERE `blog_id`='".$blog_id."'";

		if($this->connection->DeleteQuery($sql))
		{
			return true;
		}
		else 
			return'error in database';
		
	}
}