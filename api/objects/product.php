<?php
/**
*
*/
class Product {

    //Database connection and table name
    private $conn;
    private $table_name = "products";

    //Object Properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    //constructor with $db as Database Connection
    public function __construct($db) {
        $this->conn = $db;
    }

    //read products
    public function read() {
        //select query
        $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.created,p.category_id
                    FROM ".$this->table_name." p
                    LEFT JOIN categories c ON p.category_id = c.id
                    ORDER BY p.created DESC";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    //create product
    public function create() {
        $query = "INSERT INTO "
                .$this->table_name. "
                SET name=:name, price=:price, description=:description, category_id=:category_id, created=:created";

        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created = htmlspecialchars(strip_tags($this->created));

        //bind values
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":price",$this->price);
        $stmt->bindParam(":description",$this->description);
        $stmt->bindParam(":category_id",$this->category_id);
        $stmt->bindParam(":created",$this->created);

        //execute query
        if($stmt->execute()) {
            return true;
        } else {

            return false;
        }
    }

    //read one product at time
    public function readOne() {
        //query to read single record
        $query = "SELECT c.name as category_name, p.id,p.name,p.description,p.price,p.category_id,p.created
                    FROM ".$this->table_name." p
                    LEFT JOIN categories c ON p.category_id=c.id
                    WHERE p.id = ?
                    LIMIT 0,1";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //bind id of product to be updated
        $stmt->bindParam(1, $this->id);

        //execute query
        $stmt->execute();

        //get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set values to object properties
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->price = $row['price'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    //update product
    public function update() {
        //update query
        $query = "UPDATE
                    ".$this->table_name."
                SET
                    name=:name,
                    price=:price,
                    description=:description,
                    category_id=:category_id
                WHERE
                    id=:id";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitizing
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //binding new values
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':price',$this->price);
        $stmt->bindParam(':description',$this->description);
        $stmt->bindParam(':category_id',$this->category_id);
        $stmt->bindParam(":id",$this->id);

        //execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //read products with pagination
    public function readPaging($from_record_num, $records_per_page) {

        //select query
        $query = "SELECT c.name as category_name, p.id,p.name, p.description, p.price, p.category_id, p.created
                FROM
                    ".$this->table_name." p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
                ORDER BY p.created DESC
                LIMIT ?, ?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //bind param values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        //execute query
        $stmt->execute();

        //return values from database
        return $stmt;
    }

    //used for paging products
    public function count() {
        $query = "SELECT COUNT(*) as total_rows FROM ".$this->table_name."";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    //delete product
    public function delete() {
        //delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        //binding
        $stmt->bindParam(1,$this->id);

        //execute query
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //search product
    public function search($keywords) {
        //select all query
        $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                    FROM ".$this->table_name." p
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
                    ORDER BY p.created DESC";

        //prepare query statement'
        $stmt = $this->conn->prepare($query);

        //sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        //bind param
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        //execute query
        $stmt->execute();

        return $stmt;
    }
}

?>