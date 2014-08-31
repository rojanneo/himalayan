<?php

//require_once 'system/model.php';

class PhotogalleryModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}	

	public function getAllActiveImages()
	{
		$query = "SELECT * FROM photo_gallery WHERE photo_status = 1";
		$photos = $this->connection->Query($query);
		return $photos;
	}

	public function getGallery($first, $limit)
	{
		$query = "SELECT * FROM photo_gallery ORDER BY photo_id DESC LIMIT $first, $limit";	
		return $this->connection->Query($query);
	}

	public function getGalleryCount()
	{
		$query = "SELECT * FROM photo_gallery";
		return count($this->connection->Query($query));
	}

/*	public function getGalleryById($attribute_id);
	{
		$query = "SELECT * FROM photo_gallery WHERE photo_id = $attribute_id";
		$photo = $this->connection->Query($query);
		return $photo;
	}
	*/
	public function getGalleryById($id)
	{
		$query = "SELECT * FROM photo_gallery WHERE photo_id=$id";
		return $this->connection->Query($query);
	}

	public function updategallery($post_data)
	{
		if($post_data) extract($post_data);
		$query="UPDATE `photo_gallery` SET `photo_image`='".$photo."',`photo_image_resized`='".$photo."',`photo_caption`='".$pcaption."',`photo_status`=".$pstatus." WHERE `photo_id`='".$gallery_id."'";
		return $this-> connection->UpdateQuery($query);
	}

	public function deleteGalleryPost($id)
	{
		//var_dump($blog_id); die();
		$sql="DELETE FROM `photo_gallery` WHERE `photo_id`='".$id."'";

		if($this->connection->DeleteQuery($sql))
		{
			return true;
		}
		else 
			return'error in database';
	}

	public function addNewphoto($post_data)
	{
		if($post_data) extract($post_data);		
		$sql="INSERT INTO `photo_gallery`(`photo_image`, `photo_image_resized`, `photo_caption`, `photo_status`) VALUES ('".$photo."','".$photo."','".$pcaption."',".$pstatus.")";
		return $this->connection->InsertQuery($sql);
	}
}