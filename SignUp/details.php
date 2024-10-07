<?php
class Details {
    private $connection;
    private $db_type;
    private $db_host;
    private $db_port;
    private $db_user;
    private $db_pass;
    private $db_name;

    public function __contruct($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name){
        $this->db_type = $db_type;
        $this->db_host = $db_host;
        $this->db_port = $db_port;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
        $this->connection($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name);
        
    }
    public function connection($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name) {
        $dsn = "$this->db_type:host=$this->db_host;port=$this->db_port;dbname=$this->db_name";
        $this->connection = new PDO($dsn, $this->db_user, $this->db_pass);
    }

    public function getDetails() {
        $stmt = $this->connection->prepare("SELECT * FROM signup");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $details = array();
        foreach ($result as $row) {
            $user = new User($row['id'], $row['email']);
            $details[] = $details;
        }

        return $details;
    }
}
?>