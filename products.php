<?php
// connect to database
include 'config/database.php';
 
// include objects
include_once "objects/product.php";
include_once "objects/product_image.php";
include_once "objects/cart_item.php";
// set page title
$page_title="Products";
 
// page header html
include 'layout_head.php';
 
// contents will be here 
 
// layout footer code
include 'layout_foot.php';
?>
