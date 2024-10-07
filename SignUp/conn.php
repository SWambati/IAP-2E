<?php
class Conn {
    private $conn;

    public function __construct($host, $username, $password, $dbname) {
        $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>