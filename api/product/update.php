<?php

//required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Mehods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object files
include_once("../config/database.php");
include_once("../objects/product.php");

//instantiating database and product objects
$database = new Database;
$db = $database->getConnection();
$product = new Product($db);

//get product id to be edited
$data = json_decode(file_get_contents("php://input"));

//set ID property of product to be edited
$product->id = $data->id;
$product->name = $data->name;
$product->description = $data->description;
$product->price = $data->price;
$product->category_id = $data->category_id;

//update the product
if ($product->update()) {
    echo json_encode(
        array("message"=>"Product was updated.")
    );
} else { // if unable to do so
    echo json_encode(
        array("message"=>"Unable to update product.")
    );
}


?>