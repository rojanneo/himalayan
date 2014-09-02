<?php
class ProductsAdminController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		loadHelper('url');
		if(!AdminSession::isLoggedIn())
		{
			//die('here');
			redirect('admin/login');
		}
		
	}

	public function indexAction()
	{
		loadHelper('inputs');
		$page = getParam('p');
		if(!$page) $page = 1;
		$limit = 20;
		$first = ($page-1) * $limit;
		$products = getModel('products')->getProducts($first,$limit);
		$data['products'] = $products;
		$data['pagination_num'] = ceil(getModel('products')->getProductCount()/$limit);
		$this->view->renderAdmin('products/grid.phtml', $data);
	}

	public function statusToggleAction($id)
	{
		if(getModel('products')->toggleStatus($id))
		{
			redirect('admin/products');
		}
		else
		{
			redirect('admin/products');
		}
	}

	public function addAction()
	{
		loadHelper('inputs');
		$productModel = getModel('products');
		$type = getParam('type');
		$set = getParam('set');
		if($type == false and $set == false)
		{
			$types = $productModel->getAvailableProductTypes();
			$data['types'] = $types;
			$sets = getModel('Attributeset')->getAllAttributeSets();
			$data['sets'] = $sets;
			$this->view->renderAdmin('products/selectType.phtml',$data);
		}
		else
		{
				$attributes = getModel('attribute')->getAttributeCollection($set);
				$data['type'] = $type;
				$data['set'] = $set;
				$data['attributes'] = $attributes;
				$data['catlist']=getModel('category')->getCategories();
				$this->view->renderAdmin('products/new.phtml',$data);
		}
	}

	public function ajaxImageUploadAction()
	{
		$output_dir = "assets/uploads/products/";
		$outpurfiledir = 'products/';

		if(isset($_FILES["myfile"]))
		{
			$ret = array();

			$error =$_FILES["myfile"]["error"];
		   {
		    
		    	if(!is_array($_FILES["myfile"]['name'])) //single file
		    	{
		       	 	$fileName = $_FILES["myfile"]["name"];
		       	 	move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
		       	 	 //echo "<br> Error: ".$_FILES["myfile"]["error"];
		       	 	 
			       	 	 $ret[$fileName]= $output_dir.$fileName;
		    	}
		    	else
		    	{
		    	    	$fileCount = count($_FILES["myfile"]['name']);
		    		  for($i=0; $i < $fileCount; $i++)
		    		  {
		    		  	$fileName = $_FILES["myfile"]["name"][$i];
			       	 	 $ret[$fileName]= $output_dir.$fileName;
		    		    move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName );
		    		  }
		    	
		    	}
		    }
		    echo $outpurfiledir.$fileName;
		 
		}
	}


	public function loadVariationListAction()
	{
		$variations = getModel('products')->getAllVariations();
		$data['variations'] = $variations;
		$this->view->renderAdmin('products/variations-list.phtml', $data, false, false, false);
	}

	public function addVariationAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('products')->addVariation($post_data))
		{
			echo '<h3>Variation Saved</h3>';
		}

	}

	public function showVariationFormAction()
	{
		loadHelper('inputs');
		$set = getParam('set');
		$attributes = getModel('attribute')->getAttributeCollection($set);
		$data['set'] = $set;
		$data['attributes'] = $attributes;
		$this->view->renderAdmin('products/variation-form.phtml', $data, true, false, false);
	}

	public function addPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if($post_data['gallery_images'] == '') unset($post_data['gallery_images']);
		//$files = getFiles();

		//getModel('products')->addNewProduct($post_data);
		if(getModel('products')->addNewProduct($post_data))
		{
			redirect('admin/products');
		}
		else
		{
			redirect('admin/products');
		}
	}

	public function deleteImageAction($gid)
	{
		if(getModel('products')->deleteImage($gid))
		{
			echo 'success';
		}
		else
		{
			echo 'error';
		}
	}

	public function editAction($product_id)
	{
		$product = getModel('products')->getProduct($product_id);
		$data['product'] = $product;
		$set = $product['product_asid'];
		$attributes = getModel('attribute')->getAttributeCollection($set);
		$data['attributes'] = $attributes;
		$data['CatInList']=getModel('products')->getProductInCat($product_id);		
		$model=getModel('category');
		$data['catlist']=$model->getCategories();
		$data['gallery'] = getModel('products')->getGalleryImages($product_id);
		$data['type'] = $product['ptype'];
		$this->view->renderAdmin('products/new.phtml',$data);
	}

	public function editPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if($post_data['gallery_images'] == '') unset($post_data['gallery_images']);
		if(getModel('products')->updateProduct($post_data))
		{
			redirect('admin/products');
		}
		else
		{
			redirect('admin/products/edit/'.$post_data['product_id']);
		}
	}

	public function deleteAction($product_id)
	{
		if(getModel('products')->deleteProduct($product_id))
		{
			AdminSession::addSuccessMessage('Product Deleted');
			redirect('admin/products');
		}
		else
		{
			AdminSession::addSuccessMessage('Unable to delete Product');
			redirect('admin/products');
		}
	}

	public function uploadImageAction()
	{
		$imagePath = UPLOAD_URL."products/";
		$imageDir = UPLOADS_FOLDER.'products/';

	$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
	$temp = explode(".", $_FILES["img"]["name"]);
	$extension = end($temp);

	if ( in_array($extension, $allowedExts))
	  {
	  if ($_FILES["img"]["error"] > 0)
		{
			 $response = array(
				"status" => 'error',
				"message" => 'ERROR Return Code: '. $_FILES["img"]["error"],
			);
			echo "Return Code: " . $_FILES["img"]["error"] . "<br>";
		}
	  else
		{
			
		  $filename = $_FILES["img"]["tmp_name"];
		  list($width, $height) = getimagesize( $filename );

		  move_uploaded_file($filename,  $imageDir . $_FILES["img"]["name"]);

		  $response = array(
			"status" => 'success',
			"url" => $imagePath.$_FILES["img"]["name"],
			"width" => $width,
			"height" => $height
		  );
		  
		}
	  }
	else
	  {
	   $response = array(
			"status" => 'error',
			"message" => 'something went wrong',
		);
	  }
	  
	  print json_encode($response);
	}

	public function cropImageAction()
	{

		$imgUrl = $_POST['imgUrl'];
		$imgInitW = $_POST['imgInitW'];
		$imgInitH = $_POST['imgInitH'];
		$imgW = $_POST['imgW'];
		$imgH = $_POST['imgH'];
		$imgY1 = $_POST['imgY1'];
		$imgX1 = $_POST['imgX1'];
		$cropW = $_POST['cropW'];
		$cropH = $_POST['cropH'];

		$jpeg_quality = 100;
		$filename = "products/croppedImg_".rand();
		$output_filename = UPLOADS_FOLDER.$filename;

		$what = getimagesize($imgUrl);
		switch(strtolower($what['mime']))
		{
		    case 'image/png':
		        $img_r = imagecreatefrompng($imgUrl);
				$source_image = imagecreatefrompng($imgUrl);
				$type = '.png';
		        break;
		    case 'image/jpeg':
		        $img_r = imagecreatefromjpeg($imgUrl);
				$source_image = imagecreatefromjpeg($imgUrl);
				$type = '.jpeg';
		        break;
		    case 'image/gif':
		        $img_r = imagecreatefromgif($imgUrl);
				$source_image = imagecreatefromgif($imgUrl);
				$type = '.gif';
		        break;
		    default: die('image type not supported');
		}
	
	$resizedImage = imagecreatetruecolor($imgW, $imgH);
	imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, 
				$imgH, $imgInitW, $imgInitH);	
	
	
	$dest_image = imagecreatetruecolor($cropW, $cropH);
	imagecopyresampled($dest_image, $resizedImage, 0, 0, $imgX1, $imgY1, $cropW, 
				$cropH, $cropW, $cropH);	


	imagejpeg($dest_image, $output_filename.$type, $jpeg_quality);
	
	$response = array(
			"status" => 'success',
			"url" => UPLOAD_URL.$filename.$type,
			"file"=>$filename.$type
		  );
	 print json_encode($response);
	}

	// public function testAction()
	// {
	// 	loadHelper('inputs');
	// 	foreach ($_FILES['file']['name'] as $f => $name) {
	// 	 $allowedExts = array("gif", "jpeg", "jpg", "png");
	// 	    $temp = explode(".", $name);
	// 	    $extension = end($temp);

	// 	if ((($_FILES["file"]["type"][$f] == "image/gif")
	// 	|| ($_FILES["file"]["type"][$f] == "image/jpeg")
	// 	|| ($_FILES["file"]["type"][$f] == "image/jpg")
	// 	|| ($_FILES["file"]["type"][$f] == "image/png"))
	// 	&& ($_FILES["file"]["size"][$f] < 2000000)
	// 	&& in_array($extension, $allowedExts))
	// 	{
	// 	  if ($_FILES["file"]["error"][$f] > 0)
	// 	  {
	// 	    echo "Return Code: " . $_FILES["file"]["error"][$f] . "<br>";
	// 	  }
	// 	  else
	// 	  {

	// 	    if (file_exists(UPLOADS_FOLDER.'products'.DIRECTORY_SEPARATOR.$name))
	// 	    {

	// 	    }
	// 	    else
	// 	    {
	// 	        move_uploaded_file($_FILES["file"]["tmp_name"][$f], UPLOADS_FOLDER.'products'.DIRECTORY_SEPARATOR.uniqid() . "_" . $name);
	// 	    }
	// 	  }
	// 	}
	// 	else
	// 	{
	// 	    $error =  "Invalid file";
	// 	}
	// 	}
	// }
}