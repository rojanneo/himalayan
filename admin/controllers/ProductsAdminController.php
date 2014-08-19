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
		$products = getModel('products')->getAllProducts();
		$data['products'] = $products;
		$this->view->renderAdmin('products/grid.phtml', $data);
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

	public function addPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		//$files = getFiles();

		//getModel('products')->addNewProduct($post_data);
		if(getModel('products')->addNewProduct($post_data))
		{
			redirect('admin/products');
		}
		else
		{
			redirect('admin/products/add');
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
		$this->view->renderAdmin('products/new.phtml',$data);
	}

	public function editPostAction()
	{
		loadHelper('inputs');
		$post_data = getPost();
		if(getModel('products')->updateProduct($post_data))
		{
			redirect('admin/products');
		}
		else
		{
			redirect('admin/products/edit'.$post_data['product_id']);
		}
	}

	public function deleteAction($product_id)
	{
		if(getModel('products')->deleteProduct($product_id))
		{
			redirect('admin/products');
		}
		else
		{
			redirect('admin/products');
		}
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