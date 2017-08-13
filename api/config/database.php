<?php
/**
*
*/
class Database
{

    //Database Credentials
    private $host = "localhost";
    private $db_name = "api_db";
    private $username = "root";
    private $password = "mysql";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            //echo "Connected Successfully";
        } catch(PDOException $exception) {
            echo "Connection Error : ". $exception->getMessage();
        }

        return $this->conn;
    }

}


?>