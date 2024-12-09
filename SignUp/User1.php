<?php
class User {
    private $id;
    private $email;

    public function __construct($id, $email) {
        $this->id = $id;
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }
}
?>