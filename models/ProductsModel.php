<?php
class ProductsModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAvailableProductTypes()
	{
		$query = "SELECT * FROM ptype";
		$types = $this->connection->Query($query);
		return $types;
	}

	public function getAllProducts()
	{
		$query = "SELECT * FROM products_simple";
		return $this->connection->Query($query);
	}

	public function getActiveProducts()
	{
		$query = "SELECT * FROM products_simple WHERE status = 1 AND is_variation = 0 ORDER BY product_sort_order";
		return $this->connection->Query($query);		
	}

	public function getTypeNameFromId($product_type_id)
	{
		$query = "SELECT * FROM ptype where ptid = $product_type_id";
		$type = $this->connection->Query($query);
		return $type[0]['type_name'];
	}

	public function getTypeCodeFromId($product_type_id)
	{
		$query = "SELECT * FROM ptype where ptid = $product_type_id";
		$type = $this->connection->Query($query);
		return $type[0]['type_code'];	
	}

	public function isConfigurable($product_id)
	{
		$product = $this->getProduct($product_id);
		if($this->getTypeCodeFromId($product['ptype']) == 'configurable')
		{
			return true;
		}
		return false;
	}


	public function getVariations($product_id)
	{
		$sql = "SELECT associate_pid FROM `product_associations` WHERE `parent_pid` = $product_id ORDER BY product_variation_sort_order ASC";
		$variations = $this->connection->Query($sql);
		$variation_array = array();
		foreach($variations as $variation)
		{
			array_push($variation_array, $variation['associate_pid']);
		}
		return $variation_array;
	}

	public function getProduct($product_id)
	{
		$sql = "SELECT * FROM products_simple WHERE pid = $product_id";
		$product = $this->connection->Query($sql);
		return $product[0];
	}

	public function getProductAttributeById($product_id, $attribute_id)
	{
		$attribute = getModel('attribute')->getAttributeById($attribute_id);
		$sql = null;
		if($attribute[0]['atype'] == 'select')
		{
				$sql = "SELECT * FROM product_attribute_values_select where pavs_pid = $product_id AND pavs_aid = $attribute_id";
				$av = $this->connection->Query($sql);
				return $av[0]['pavs_vid'];
		}
		else
		{
			$atype = $attribute[0]['atype'];
			$sql = "SELECT * FROM product_attribute_values_".$atype." where pav".$atype[0]."_pid = $product_id AND pav".$atype[0]."_aid = $attribute_id";
			$av = $this->connection->Query($sql);
			if($av)
			return $av[0]['value'];
			else
				return false;
		}
	}

	public function getProductAttributeByCode($product_id, $attribute_code)
	{
		$attribute = getModel('attribute')->getAttributeByCode($attribute_code);
		$sql = null;
		if($attribute['atype'] == 'select')
		{
				$sql = "SELECT * FROM product_attribute_values_select where pavs_pid = $product_id AND pavs_aid = ".$attribute['aid'];
				$av = $this->connection->Query($sql);
				if($av)
				{
					$value = (getModel('attribute')->getAttributeValueByValueId($av[0]['pavs_vid']));
					return $value['value'];				
				}
				else
				{
					return false;
				}
		}
		else
		{
			$atype = $attribute['atype'];
			$sql = "SELECT * FROM product_attribute_values_".$atype." where pav".$atype[0]."_pid = $product_id AND pav".$atype[0]."_aid = ".$attribute['aid'];
			$av = $this->connection->Query($sql);
			if($av)
			return $av[0]['value'];
			else
				return false;
		}
	}

	public function getThumbnailImage($product_id)
	{
		$sql = "SELECT * FROM `product_attribute_values_gallery` WHERE `pavg_pid` = $product_id AND `is_thumbnail_image` = 1";
		$thumbnail = $this->connection->Query($sql);
		if($thumbnail)
		{
			$image = null;
			$file = fopen("flickr.csv","r");
			$hdc_name = $thumbnail[0]['value'];
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
		else
		return false;
	}

	public function getBaseImage($product_id)
	{
		$sql = "SELECT * FROM `product_attribute_values_gallery` WHERE `pavg_pid` = $product_id AND `is_base_image` = 1";
		$thumbnail = $this->connection->Query($sql);
		if($thumbnail)
		{
			return UPLOAD_URL.$thumbnail[0]['value'];
		}
		else
		return false;
	}

	public function getSmallImage($product_id)
	{
		$sql = "SELECT * FROM `product_attribute_values_gallery` WHERE `pavg_pid` = $product_id AND `is_small_image` = 1";
		$small = $this->connection->Query($sql);
		if($small)
		{
			return UPLOAD_URL.$small[0]['value'];
		}
		else
		return false;		
	}

	public function getGalleryImages($product_id)
	{
		$sql = "SELECT * FROM product_attribute_values_gallery WHERE pavg_pid = $product_id";
		$gallery = $this->connection->Query($sql);
		$images = array();
		$count = 0;
		foreach($gallery as $image)
		{
			$image['value'] = str_replace('\\','/',$image['value']);
			$gallery[$count++]['value'] = $image['value'];
		}
		if($gallery)
		return $gallery;
		else return false;
	}

	public function deleteImage($gid)
	{

		$sql = "SELECT * FROM product_attribute_values_gallery WHERE gid = $gid";
			$images = $this->connection->Query($sql);

			foreach($images as $image)
			{
				unlink(UPLOADS_FOLDER.$image['value']);
			}

		$sql = "DELETE FROM product_attribute_values_gallery WHERE gid = $gid";
		return $this->connection->DeleteQuery($sql);
	}

	public function saveImages($product_id, $base_image, $thumbnail)
	{
		$filenames = array();
		$base_count = 0;
		$thumb_count = 0;
		foreach ($_FILES['gallery']['name'] as $f => $name) {
		 $allowedExts = array("gif", "jpeg", "jpg", "png");
		    $temp = explode(".", $name);
		    $extension = end($temp);

		if ((($_FILES["gallery"]["type"][$f] == "image/gif")
		|| ($_FILES["gallery"]["type"][$f] == "image/jpeg")
		|| ($_FILES["gallery"]["type"][$f] == "image/jpg")
		|| ($_FILES["gallery"]["type"][$f] == "image/png"))
		&& ($_FILES["gallery"]["size"][$f] < 2000000)
		&& in_array($extension, $allowedExts))
		{
		  if ($_FILES["gallery"]["error"][$f] > 0)
		  {
		    echo "Return Code: " . $_FILES["gallery"]["error"][$f] . "<br>";
		  }
		  else
		  {

		    if (file_exists(UPLOADS_FOLDER.'products'.DIRECTORY_SEPARATOR.$name))
		    {

		    }
		    else
		    {
		    	$filename = 'products'.DIRECTORY_SEPARATOR.uniqid() . "_" . $name;
		    	if($base_count == $base_image) 
		    		{$base = 1; } else {$base = 0;}
		    	$base_count++;
		    	if($thumb_count == $thumbnail) {$thumb = 1;} else $thumb = 0;
		    	$thumb_count++;
		        move_uploaded_file($_FILES["gallery"]["tmp_name"][$f], UPLOADS_FOLDER.$filename);
		        $filename = str_replace('\\','\\\\',$filename);
		        $sql = "INSERT INTO `product_attribute_values_gallery`(`pavg_pid`, `value`, `is_base_image`, `is_thumbnail_image`) VALUES ($product_id,'$filename',$base,$thumb)";
		       $result = $this->connection->InsertQuery($sql);
		    }
		  }
		}
		else
		{
		    $error =  "Invalid file";
		}
		}
		return $result;
	}

	public function getAllVariations()
	{
		$sql = "SELECT * FROM products_simple WHERE is_variation = 1 ORDER BY pid ASC";
		return $this->connection->Query($sql);
	}

	public function addVariation($post_data)
	{
		if($post_data) extract($post_data);
		if(!isset($is_variation))
		{
			$sql = "INSERT INTO `products_simple`(`pname`, `psku`, `ptype`, `product_asid`, `quantity`, `in_stock`,`status`) VALUES 
			('$name','$sku','$product_type','$attribute_set','$quantity','$in_stock','$status')";
		}
		else
		{
			$sql = "INSERT INTO `products_simple`(`pname`, `psku`, `ptype`, `product_asid`, `quantity`, `in_stock`,`status`, `is_variation`) VALUES 
			('$name','$sku','$product_type','$attribute_set','$quantity','$in_stock','$status',$is_variation)";			
		}

		$result1 = $this->connection->InsertQuery($sql);
			$pid = $this->connection->GetInsertID();
		$attributeTable = 'product_attribute_values_';

		$aModel = getModel('attribute');
		foreach($attributes as $acode => $attrib)
		{
			$attribute = $aModel->getAttributeByCode($acode);
			$atype = $attribute['atype'];
			$table =$attributeTable.$atype;
			$a = $atype[0];
			if($atype == 'select')
			{
					$sql = "INSERT INTO ".$table."(pavs_pid, pavs_aid, pavs_vid) VALUES(".$pid.",".$attribute['aid'].",".$attrib.")";
			}
			else
			{
				$sql = "INSERT INTO ".$table."(pav".$a."_pid,pav".$a."_aid,value) VALUES(".$pid.",".$attribute['aid'].",'".$attrib."')";				
			}
			$result2 = $this->connection->InsertQuery($sql);
		}

		if(isset($gallery_images))
		{
			$gallery_images = rtrim($gallery_images,',');
			$gallery_images = explode(',',$gallery_images);
			foreach($gallery_images as $gallery_image){
				$sql = "INSERT INTO product_attribute_values_gallery(pavg_pid,value,is_base_image,is_thumbnail_image) VALUES(".$pid.",'".$gallery_image."', 0, 0)";
				$result3 = $this->connection->InsertQuery($sql);
			}
		}

		$this->deleteUnnecessaryProductImages();

		return $result1 and $result2;
	}

	public function getFirstCategory($product_id)
	{
		$sql = "SELECT * FROM `product_cat` WHERE pid = $product_id";
		$categories = $this->connection->Query($sql);
		return $categories[0];
	}

	public function addNewProduct($post_data)
	{
		if($post_data) extract($post_data);
		
		$baseimage=$radiobasval;
		$thumbimage=$radiothumval;
		$smallimage=$radiosmallval;
		
		if(!isset($quantity)) $quantity = 0;
		if(!isset($in_stock)) $in_stock = 1;

		if(!isset($is_variation))
		{
			$sql = "INSERT INTO `products_simple`(`pname`, `psku`, `ptype`, `product_asid`, `quantity`, `in_stock`,`status`,`product_sort_order`) VALUES 
			('$name','$sku','$product_type','$attribute_set','$quantity','$in_stock','$status','$product_sort_order')";
		}
		else
		{
			$sql = "INSERT INTO `products_simple`(`pname`, `psku`, `ptype`, `product_asid`, `quantity`, `in_stock`,`status`, `is_variation`,`product_sort_order`) VALUES 
			('$name','$sku','$product_type','$attribute_set','$quantity','$in_stock','$status',$is_variation,'$product_sort_order')";			
		}
		$result1 = $this->connection->InsertQuery($sql);

		
		$pid = $this->connection->GetInsertID();
		if(isset($pccheck_list))
		{
		foreach ($pccheck_list as $pccheck_list) 
			{
			$sql1="INSERT INTO `product_cat`(`pid`, `category_id`) VALUES ('".$pid."','".$pccheck_list."')";
			$this->connection->InsertQuery($sql1);
			}		
		}


		$attributeTable = 'product_attribute_values_';

		$aModel = getModel('attribute');
		foreach($attributes as $acode => $attrib)
		{
			$attribute = $aModel->getAttributeByCode($acode);
			$atype = $attribute['atype'];
			$table =$attributeTable.$atype;
			$a = $atype[0];
			if($atype == 'select')
			{
					$sql = "INSERT INTO ".$table."(pavs_pid, pavs_aid, pavs_vid) VALUES(".$pid.",".$attribute['aid'].",".$attrib.")";
			}
			else
			{
				$sql = "INSERT INTO ".$table."(pav".$a."_pid,pav".$a."_aid,value) VALUES(".$pid.",".$attribute['aid'].",'".$attrib."')";				
			}
			$result2 = $this->connection->InsertQuery($sql);
		}
		
		// if(isset($base_image) and isset($thumbnail))
		// 	$result3 = $this->saveImages($pid, $base_image, $thumbnail);
		// else
		// {
		// 	$result3 = $this->saveImages($pid, 0, 0);
		// }

		if(isset($gallery_images))
		{
			$gallery_images = rtrim($gallery_images,',');
			$gallery_images = explode(',',$gallery_images);
			
			foreach($gallery_images as $gallery_image)
			{
				if($gallery_image==$baseimage){ $i=1; }else{ $i=0; }
				if($gallery_image==$thumbimage){ $j=1; }else{ $j=0; }
				if($gallery_image==$smallimage){ $k=1; }else{ $k=0; }
				$sql = "INSERT INTO product_attribute_values_gallery(pavg_pid,value,is_base_image,is_thumbnail_image,is_small_image) VALUES(".$pid.",'".$gallery_image."', ".$i.", ".$j.",".$k.")";
				$result3 = $this->connection->InsertQuery($sql);
			}
		}

		$this->deleteUnnecessaryProductImages();

		if(isset($variations))
		{
			foreach($variations as $variation)
			{
				$product_variation_sort_order_variation	= $product_variation_sort_order[$variation] ;
				$sql = "INSERT INTO `product_associations`(`parent_pid`, `associate_pid`,`product_variation_sort_order`) VALUES ($pid, $variation,$product_variation_sort_order_variation)";
				$this->connection->InsertQuery($sql);
								
			}
		}
		
		return $result1 and $result2 and $result3;
	}

	public function deleteUnnecessaryProductImages()
	{
		$sql = "SELECT * FROM product_attribute_values_gallery";
		$images = $this->connection->Query($sql);

		foreach (glob("assets/uploads/products/*.*") as $imagesFolder)
		{
			$imageExists = false;
			foreach($images as $image)
			{
				if($imagesFolder == 'assets/uploads/'.$image['value'])
				{
					$imageExists = true;
				}
			}
			if($imageExists == false)
			{
				$filename = explode('/',$imagesFolder)[3];
				$file = UPLOADS_FOLDER.'products'.DIRECTORY_SEPARATOR.$filename;
				 unlink($file);
				//echo $file.'<br>';
			}
		}
	}

	public function deleteProduct($product_id)
	{
			$sql = "SELECT * FROM product_attribute_values_gallery WHERE pavg_pid = $product_id";
			$images = $this->connection->Query($sql);

			foreach($images as $image)
			{
				unlink(UPLOADS_FOLDER.$image['value']);
			}
			$sql = "DELETE FROM product_attribute_values_int WHERE pavi_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);
			$sql = "DELETE FROM product_attribute_values_text WHERE pavt_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);
			$sql = "DELETE FROM product_attribute_values_varchar WHERE pavv_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);
			$sql = "DELETE FROM product_attribute_values_select WHERE pavs_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);



			$sql = "DELETE FROM product_attribute_values_gallery WHERE pavg_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);

			$sql = "DELETE FROM products_simple WHERE pid = $product_id";
			$result = $this->connection->DeleteQuery($sql);
			return $result;
	}

	public function updateProduct($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$baseimage=$radiobasval;
		$thumbimage=$radiothumval;
		$smallimage=$radiosmallval;
		if(!isset($quantity)) $quantity = 0;
		if(!isset($in_stock)) $in_stock = 0;
		$sql = "UPDATE products_simple SET pname = '".$name."', psku = '".$sku."', ptype='".$product_type."', product_asid = '".$attribute_set."',
		 quantity = '".$quantity."', in_stock = '".$in_stock."', status = '".$status."', product_sort_order='".$product_sort_order."' WHERE pid = '".$product_id."'";
		$result = $this->connection->UpdateQuery($sql);
		$result2 = true;
		$getProductInCatval=$this->getProductInCat($product_id);
		//var_dump($getProductInCatval);
		if(isset($pccheck_list))
		{
				$sql="DELETE FROM `product_cat` WHERE `pid`='".$product_id."'";
				$this->connection->DeleteQuery($sql);
			foreach ($pccheck_list as $pccheck_list) 
			{
				$sql1="INSERT INTO `product_cat`(`pid`, `category_id`) VALUES ('".$product_id."','".$pccheck_list."')";
				$this->connection->InsertQuery($sql1);
			}	
		}

		if(isset($attributes))
		{
			$sql = "DELETE FROM product_attribute_values_int WHERE pavi_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);
			$sql = "DELETE FROM product_attribute_values_text WHERE pavt_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);
			$sql = "DELETE FROM product_attribute_values_varchar WHERE pavv_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);
			$sql = "DELETE FROM product_attribute_values_select WHERE pavs_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);


			$attributeTable = 'product_attribute_values_';

			$aModel = getModel('attribute');
			foreach($attributes as $acode => $attrib)
			{
				$attribute = $aModel->getAttributeByCode($acode);
				$atype = $attribute['atype'];
				$table =$attributeTable.$atype;
				$a = $atype[0];
				if($atype == 'select')
				{
						$sql = "INSERT INTO ".$table."(pavs_pid, pavs_aid, pavs_vid) VALUES(".$product_id.",".$attribute['aid'].",".$attrib.")";
				}
				else
				{
					$sql = "INSERT INTO ".$table."(pav".$a."_pid,pav".$a."_aid,value) VALUES(".$product_id.",".$attribute['aid'].",'".mysql_escape_string($attrib)."')";				
				}
				$result2 = $this->connection->InsertQuery($sql);
			}

		 
		}
		//for previously set images base images been changed
		$previmagtobebas="SELECT * FROM `product_attribute_values_gallery` WHERE `is_base_image`=1 AND `pavg_pid`=$product_id";
		$prevbas=$this->connection->Query($previmagtobebas);
		if($prevbas)
		{
			$sql="UPDATE `product_attribute_values_gallery` SET `is_base_image`=0 WHERE `pavg_pid`= ".$prevbas[0]['pavg_pid']."";
			$this->connection->UpdateQuery($sql);
		}

		$setbase="UPDATE `product_attribute_values_gallery` SET `is_base_image`=1 WHERE `value`='".$baseimage."' AND `pavg_pid`= ".$product_id." ";
		$this->connection->UpdateQuery($setbase);
		// finished of base images

		//for previously set images as thumb images been changed
		$previmagtobethumb="SELECT * FROM `product_attribute_values_gallery` WHERE `is_thumbnail_image`=1 AND `pavg_pid`=$product_id";
		$prevthumb=$this->connection->Query($previmagtobethumb);
		if($prevthumb)
		{
			$sqlthumb="UPDATE `product_attribute_values_gallery` SET `is_thumbnail_image`=0 WHERE `pavg_pid`= ".$prevthumb[0]['pavg_pid']."";
			$this->connection->UpdateQuery($sqlthumb);
		}

		$setthumb="UPDATE `product_attribute_values_gallery` SET `is_thumbnail_image`=1 WHERE `value`='".$thumbimage."' AND `pavg_pid`= ".$product_id." ";
		$this->connection->UpdateQuery($setthumb);
		//end of thumb image

		//for previously set iamges as small images been changed
		$previmagtobesmall="SELECT * FROM `product_attribute_values_gallery` WHERE `is_small_image`=1 AND `pavg_pid`=$product_id";
		$prevsmall=$this->connection->Query($previmagtobesmall);
		if($prevsmall)
		{
			$sqlsmall="UPDATE `product_attribute_values_gallery` SET `is_small_image`=0 WHERE `pavg_pid`= ".$prevsmall[0]['pavg_pid']."";
			$this->connection->UpdateQuery($sqlsmall);
		}

		$setsmall="UPDATE `product_attribute_values_gallery` SET `is_small_image`=1 WHERE `value`='".$smallimage."' AND `pavg_pid`= ".$product_id." ";
		$this->connection->UpdateQuery($setsmall);
		//end of small image
		
		if(isset($gallery_images))
		{
			$gallery_images = rtrim($gallery_images,',');
			$gallery_images = explode(',',$gallery_images);
			foreach($gallery_images as $gallery_image){
				if($gallery_image==$baseimage){ $i=1; }else{ $i=0; }
				if($gallery_image==$thumbimage){ $j=1; }else{ $j=0; }
				if($gallery_image==$smallimage){ $k=1; }else{ $k=0; }
				$sql = "INSERT INTO product_attribute_values_gallery(pavg_pid,value,is_base_image,is_thumbnail_image,is_small_image) VALUES(".$product_id.",'".$gallery_image."', ".$i.", ".$j.",".$k.")";
				$result3 = $this->connection->InsertQuery($sql);
			}
		}

		$this->deleteUnnecessaryProductImages();


		if(isset($variations))
		{
			$sql = "DELETE FROM `product_associations` WHERE parent_pid = $product_id";
			$this->connection->DeleteQuery($sql);
			foreach($variations as $variation)
			{
				$product_variation_sort_order_variation	= $product_variation_sort_order[$variation] ;
				$sql = "INSERT INTO `product_associations`(`parent_pid`, `associate_pid`,`product_variation_sort_order`) VALUES ($product_id, $variation,'".$product_variation_sort_order_variation."')";
				$this->connection->InsertQuery($sql);				
			}
		}

	return $result and $result2;

	}

	public function getProductInCat($product_id)
	{
		$sql="SELECT * FROM product_cat WHERE `pid`='".$product_id."'";
		$query=$this->connection->Query($sql);
		$val=null;
		$i=1;
		foreach ($query as $query) 
		{
			$val[$i]=$query['category_id'];
			$i++;
		}
		return $val;
	}

	public function getCategories($pid)
	{
		$sql="SELECT * FROM product_cat WHERE `pid`='".$pid."'";
		$query=$this->connection->Query($sql);
		$val=array();
		$i=1;
		foreach ($query as $query) 
		{
			array_push($val, $query['category_id']);
		}
		return $val;
	}

	public function getAssociatedProducts($pid)
	{
		$sql = "SELECT * FROM product_associations WHERE parent_pid = $pid";
		$rows = $this->connection->Query($sql);
		$associated = array();
		foreach($rows as $row)
		{
			array_push($associated, $row['associate_pid']);
		}
		return $associated;
	}
	//for sort order

	public function getAssociatedProductsSort($pid)
	{
		$sql= "SELECT `associate_pid`,`product_variation_sort_order` FROM `product_associations` WHERE `parent_pid`=$pid";
		$associated=$this->connection->Query($sql);		
		return $associated;
	}


	public function toggleStatus($id)
	{
		$sql = "SELECT * FROM products_simple WHERE pid = $id";
		$status = $this->connection->Query($sql)[0]['status'];
		if($status == 1)
		{
			$sql = "UPDATE products_simple SET status = 0 WHERE pid = $id";
			return $this->connection->UpdateQuery($sql);
		}
		else
		{
			$sql = "UPDATE products_simple SET status = 1 WHERE pid = $id";
			return $this->connection->UpdateQuery($sql);
		}
	}

	public function getProductCount()
	{
		$sql = "SELECT * FROM products_simple";
		$products = $this->connection->Query($sql);
		return count($products);
	}

	public function getProducts($first, $limit)
	{
		$sql = "SELECT * FROM products_simple ORDER BY pid DESC Limit $first,$limit";
		return $this->connection->Query($sql);
	}

	public function getProductsFromCategoryId($category_id)
	{
		$sql = "SELECT * FROM product_cat WHERE category_id = $category_id order by pid asc";
		$pids = $this->connection->Query($sql);
		$product_array = array();
		foreach($pids as $pid)
		{
			$sql = "SELECT * FROM products_simple WHERE pid = ".$pid['pid']." and is_variation = 0 and status = 1";
			$product = $this->connection->Query($sql);
			if(($product))
			{
				$product = $product[0];
			array_push($product_array, $product);
			}
		}
		return $product_array;
	}
}