<?php
class BlogAdminController extends Controller
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
		$data['bloglistposts']=getModel('blog')->getBlogs($first,$limit);
		$data['pagination_num'] = ceil(getModel('blog')->getBlogCount()/$limit);
		$this->view->renderAdmin('blog/blog_view.phtml',$data);
	}

	public function addnewblogAction()
	{		
		$this->view->renderAdmin('blog/new.phtml');
	}

	public function addblogpostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('blog')->addNewBlog($post_data))
		{
			redirect('admin/blog');
		}
		else
		{
			redirect('admin/blog/addnewblog');
		}
	}

	public function editblogAction($attribute_id)
	{

		$blog = getModel('blog')->getBlogById($attribute_id);	
		$data['blog'] = $blog[0];
		if(!empty($data['blog'] ))
		{ 
			$this->view->renderAdmin('blog/new.phtml',$data);
		}
		else 
		{
			var_dump($data['blog'] ); die();
		}
		
	}

	public function editblogpostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();		
		if(getModel('blog')->updateblog($post_data))
		{
			redirect('admin/blog');
		}
		else
		{
			redirect('admin/blog/addnewblog');
		}	
	}

	public function deleteblogAction($blog_id)
	{
		if(getModel('blog')->deleteBlogPost($blog_id))
		{
			redirect('admin/blog');
		}
		else
		{
			redirect('admin/blog/addnewblog');
		}
	}

	
	public function uploadImageAction()
	{
		$imagePath = UPLOAD_URL."cms/";
		$imageDir = UPLOADS_FOLDER.'cms/';

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
$filename = "cms/croppedImg_".rand();
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