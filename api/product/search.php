<?php

//require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database config and objects file
include_once("../config/database.php");
include_once("../objects/product.php");

//create database and product object
$database = new Database;
$db = $database->getConnection();
$product = new Product($db);

//get keywords
$keywords = isset($_GET['s']) ? $_GET['s'] : "";

//query products
$stmt = $product->search($keywords);
$num = $stmt->rowCount();

//check if more than 0 records found
if($num > 0) {

    //creating products array
    $products_arr = array();
    $products_arr['records'] = array();

    //retrieve our table contents
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //extract contents
        extract($row);

        $product_item = array(
            "id"=>$id,
            "name"=>$name,
            "description"=>$description,
            "price"=>$price,
            "category_id"=>$category_id,
            "category_name"=>$category_name
        );

        array_push($products_arr['records'], $product_item);
    }
    echo json_encode($products_arr);
} else {
    echo json_encode(
        array("message"=>"No Products Found.")
    );
}

?>