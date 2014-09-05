<?php include('models/ProductsModel.php');?>
<?php $productModel = new ProductsModel();
$desc = $productModel->getProductAttributeByCode(104, 'short_description');?>
<?php echo $desc;?>