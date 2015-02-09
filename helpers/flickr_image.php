<?php

if(!function_exists('getFlickrCategoryImage'))
{
	function getFlickrCategoryImage($category_image_name)
	{
		$image = null;
			$file = fopen("flickr.csv","r");
			$hdc_name = $category_image_name;
			while(! feof($file))
			  {
			  $row = (fgetcsv($file));
				  if($row[0] == $hdc_name)
				  {
				  	$image =  $row[1];
				  }
			  }

			fclose($file);
			return $image;
	}
}