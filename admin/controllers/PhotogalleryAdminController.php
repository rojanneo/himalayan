<?php
class PhotogalleryAdminController extends Controller
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
		$limit = 10;
		$first = ($page-1) * $limit;
		$data['gallery']=getModel('photogallery')->getGallery($first,$limit);
		$data['pagination_num'] = ceil(getModel('photogallery')->getGalleryCount()/$limit);
		$this->view->renderAdmin('photogallery/gallery_view.phtml',$data);
	}

	public function addnewphotoAction()
	{		
		$this->view->renderAdmin('photogallery/new.phtml');
	}

	public function addGallerypostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if (empty($post_data["photo"]))
		{
			$data['gallery']['photo_status']=$post_data['pstatus'];
			$data['gallery']['photo_caption']=$post_data['pcaption'];
		$data['false']="Please add the photo";
			$this->view->renderAdmin('photogallery/new.phtml',$data);
		}
		else
		{
			if(getModel('photogallery')->addNewphoto($post_data))
			{
			redirect('admin/photogallery');
			}
			else
			{
			redirect('admin/photogallery/addnewphoto');
			}
		}
	}

	public function editgalleryAction($attribute_id)
	{
		$editgallery = getModel('photogallery')->getGalleryById($attribute_id);	
		$data['gallery'] = $editgallery[0];
		if(!empty($data['gallery'] ))
		{ 
			$this->view->renderAdmin('photogallery/new.phtml',$data);
		}
		else 
		{
			var_dump($data['gallery'] ); die();
		}
		
	}

	public function editGallerypostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if (empty($post_data["photo"]))
		{
			$data['gallery']['photo_status']=$post_data['pstatus'];
			$data['gallery']['photo_caption']=$post_data['pcaption'];
			$data['gallery']['photo_id']=$post_data['gallery_id'];
			$data['false']="Please add the photo";
			$this->view->renderAdmin('photogallery/new.phtml',$data);
		}
		else
		{
		loadHelper('inputs');
		$post_data = getPost();		
		if(getModel('photogallery')->updategallery($post_data))
		{
			redirect('admin/photogallery');
		}
		else
		{
			redirect('admin/photogallery/addnewphoto');
		}
		}	
	}

	public function deletegalleryAction($blog_id)
	{
		if(getModel('photogallery')->deleteGalleryPost($blog_id))
		{
			redirect('admin/photogallery');
		}
		else
		{
			redirect('admin/photogallery/addnewphoto');
		}
	}

	

	
	public function uploadImageAction()
	{
		$imagePath = UPLOAD_URL."photogallery/";
		$imageDir = UPLOADS_FOLDER.'photogallery/';

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
$filename = "photogallery/croppedImg_".rand();
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