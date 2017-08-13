<?php

//required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-ALlow-Mehods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

//include datbase config and objects
include_once("../config/database.php");
include_once("../objects/product.php");

//instantiating objects
$database = new Database;
$db = $database->getConnection();
$product = new Product($db);

// set id of product
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

//read product details
$product->readOne();

//create product array
$product_arr = array (
    "id"=> $product->id,
    "name"=> $product->name,
    "description"=>$product->description,
    "price"=>$product->price,
    "category_id"=>$product->category_id,
    "category_name"=>$product->category_name
);

//make it json encoded
print_r(json_encode($product_arr));
?>