<?php

//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

date_default_timezone_set("Asia/Kolkata");

//get database connection and product object
include_once("../config/database.php");
include_once("../objects/product.php");

//instantiate new objects
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

//get posted data
$data = json_decode(file_get_contents("php://input"));

//set product property values
$product->name = $data->name;
$product->description = $data->description;
$product->price = $data->price;
$product->category_id = $data->category_id;
$product->created = date('d-m-Y H:i:s');

//lets create product now
if($product->create()) {
    echo json_encode(
        array("message"=>"Product was created.")
    );
} else { // if unable to create product, notify user
    echo json_encode(
        array("message"=>"Unable to create product.")
    );
}

?>