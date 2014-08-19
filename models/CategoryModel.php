<?php

class CategoryModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCategories()
	{
		$query = 'Select * from categories';
		$categories = $this->connection->Query($query);
		return $categories;
	}

	public function cat_hierarchy()
	{
		$query='SELECT * FROM `categories` WHERE `is_root`=1';
		$cat_hier=$this->connection->Query($query);	
		if(!empty($cat_hier))
		{ 
			$category='<ul>';
			foreach ($cat_hier as $cat_hier)
			{
				$category.=$this->cat_ul($cat_hier['category_name'],$cat_hier['category_id']);
			}
			$category.='</ul>';
			return $category;
		}
		else{ return 'You can create new category.';} 

	}

	public function cat_ul($category_name,$category_id)
	{
		$category='<li>'.$category_name.'<a href="'.ADMIN_URL.'category/editcat/'.$category_id.'">edit</a> <a href="'.ADMIN_URL.'category/deletecat/'.$category_id.'">DELETE</a></li>';
			$query1='SELECT * FROM `categories` WHERE `parent_id`='.$category_id.'';
			$cat_hier1=$this->connection->Query($query1);
			if(!empty($cat_hier1))
			{
				$category.='<ul>';
				foreach ($cat_hier1 as $cat_hier1) 
				{
					$category.=$this->cat_ul($cat_hier1['category_name'],$cat_hier1['category_id']);
				}
				$category.='</ul>';
			}
		return $category;
	}

	public function addNewcategory($post_data)
	{
		if($post_data) extract($post_data);
		$cslug=str_replace(" ","_",$cname).uniqid();
		if($ctype==0)
		{ 
			$sql="INSERT INTO `categories`(`category_name`, `cat_slug`, `category_description`, `parent_id`, `is_root`) VALUES ('".$cname."','".$cslug."','".$cdescription."',0,1)";
		}
		else
		{
			$sql="INSERT INTO `categories`(`category_name`, `cat_slug`, `category_description`, `parent_id`, `is_root`) VALUES ('".$cname."','".$cslug."','".$cdescription."','".$ctype."',0)";
		}
		$result1 = $this->connection->InsertQuery($sql);
		return true;
	}

	public function getCategoryById($category_id)
	{
		$sql = "SELECT * FROM `categories` WHERE `category_id`=$category_id";
		return $this->connection->Query($sql);
	}

	public function updatecatval($post_data)
	{
		if($post_data) extract($post_data);	
		if($ctype==0)
		{
			$sql="UPDATE `categories` SET `category_name`='".$cname."',`category_description`='".$cdescription."',`parent_id`=0,`is_root`= 1 WHERE `category_id`='".$attribute_id."'";
		}
		else
		{	
		$sql="UPDATE `categories` SET `category_name`='".$cname."',`category_description`='".$cdescription."',`parent_id`='".$ctype."',`is_root`=0 WHERE `category_id`='".$attribute_id."'";
		}
		$this->connection->UpdateQuery($sql);
		return true;
	}

	public function deletecatval($category_id)
	{
		$sql="DELETE FROM `categories` WHERE `category_id`='".$category_id."'";

		if($this->connection->DeleteQuery($sql))
		{
			$sql1="SELECT * FROM `categories` WHERE `parent_id`=$category_id";
			$queryval=$this->connection->Query($sql1);
			foreach ($queryval as $queryval) {
				$sql="UPDATE `categories` SET `parent_id`=0,`is_root`= 1 WHERE `category_id`='".$queryval['category_id']."'";
				//echo $sql; die;				
				$this->connection->UpdateQuery($sql);
			}
		}
	}
}