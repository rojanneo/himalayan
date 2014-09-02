<?php
include('system/Image.php');

$resizeObj = new Image('http://rojan/himalayan/assets/uploads/products/croppedImg_218.jpeg');
 
// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
$resizeObj -> resizeImage(600, 300, 'portrait');
 
// *** 3) Save image
$resizeObj -> saveImage('assets/uploads/products/resized/sample1-resized.jpg', 100);