<?php
class CategoryAdminController extends Controller
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

	public function testAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		getModel('category')->saveSortOrder($post_data);
		redirect('admin/category');
		var_dump($post_data);die;
	}

	public function indexAction()
	{
		$model=getModel('category');
		$data['catagoryval']=$cat=$model->cat_hierarchy();
		$this->view->renderAdmin('categories/category.phtml',$data);
	}

	public function addnewAction()
	{
		$model=getModel('category');
		$data['catlist']=$model->getCategories();
		$this->view->renderAdmin('categories/new.phtml',$data);
	}

	public function addcatpostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('category')->addNewcategory($post_data))
		{
			redirect('admin/category');
		}
		else
		{
			redirect('admin/category/addnew');
		}
	}

	public function editcatAction($attribute_id)
	{
		$model=getModel('category');
		$data['catlist']=$model->getCategories();
		$category = getModel('category')->getCategoryById($attribute_id);		
		$data['category'] = $category[0];
		if(!empty($data['category'] ))
		{ 
			$this->view->renderAdmin('categories/new.phtml',$data);
		}
		else 
		{
			var_dump($data['category'] ); die();
		}
		
	}

	public function editcatpostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();	
		if(getModel('category')->updatecatval($post_data))
		{
			redirect('admin/category');
		}
		else
		{
			redirect('admin/category/addnew');
		}	
	}

	public function deleteImageAction($id)
	{
		if(getModel('category')->deleteImage($id))
		{
			redirect('admin/category/editcat/'.$id);
		}
		else
		{
			redirect('admin/category/editcat/'.$id);
		}
	}

	public function deletecatAction($category_id)
	{
		$model=getModel('category');
		if(getModel('category')->deletecatval($category_id))
		{
			redirect('admin/category');
		}
		else
		{
			redirect('admin/category/addnew');
		}
	}
public function uploadImageAction()
	{
		$imagePath = UPLOAD_URL."category/";
		$imageDir = UPLOADS_FOLDER.'category/';

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
$filename = "category/croppedImg_".rand();
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



}