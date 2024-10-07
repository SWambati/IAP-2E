<?php
class UserDAO {
    private $conn;

    public function __construct(Conn $connection) {
        $this->conn = $connection->getConnection();
    }

    public function getUserDetails() {
        $stmt = $this->conn->prepare("SELECT * FROM signup");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = array();
        foreach ($result as $row) {
            $user = new User($row['ID'], $row['email']);
            $users[] = $user;
        }

        return $users;
    }
}
?>