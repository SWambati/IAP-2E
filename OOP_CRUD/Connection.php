<?php
class Connection{
    public $servername = 'localhost';
    public $dbName = 'users';
    public $username = 'root';
    public $password = '';
    public $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=$this->servername;dbname=$this->dbName;charset=utf8mb4", $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
?>