<?php

//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Mehods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization ,X-Requested-With");

//include files
include_once("../config/database.php");
include_once("../objects/product.php");

//get database connection
$database = new Database;
$db = $database->getConnection();

//prepare product object
$product = new Product($db);

//get product_id
$data = json_decode(file_get_contents("php://input"));

//set product id to be deleted
$product->id = $data->id;

//delete the product
if($product->delete()) {
    echo '{';
    echo '"message": "Product Deleted Successfully."';
    echo '}';
} else { //if it unable to do so
    echo '{';
    echo '"message": "Unable to Delete Product."';
    echo '}';
}

?>