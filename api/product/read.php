<?php

//require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files
include_once("../config/database.php");
include_once("../objects/product.php");

//instantiate database and product object
$database = new Database;
$db = $database->getConnection();
$product = new Product($db);

//query products
$stmt = $product->read();
$num = $stmt->rowCount();

//check if more than 0 records found
if ($num > 0) {

    //creating products array
    $products_arr = array();
    $products_arr['records'] = array();

    //retrieve our table contents
    //fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //extract row
        //this will make $row['name'] to
        //just $name only
        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );

        array_push($products_arr["records"], $product_item);
    }
    echo json_encode($products_arr);
} else {
    echo json_encode(
        array("message"=>"No Products Found.")
    );
}
?>