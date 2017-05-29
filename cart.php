<?php
// connect to database
include 'config/database.php';
 
// include objects
include_once "objects/product.php";
include_once "objects/product_image.php";
include_once "objects/cart_item.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$cart_item = new CartItem($db);
 
// set page title
$page_title="Cart";
 
// include page header html
include 'layout_head.php';
 
// contents will be here 
 
// layout footer 
include 'layout_foot.php';
?>
