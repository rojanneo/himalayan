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

}