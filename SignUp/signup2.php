<?php
include "connection.php";
require "Constants.php";
require "dbConnection.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query with parameterized values
    $stmt = $conn->prepare("INSERT INTO signup (email, password) VALUES (:email, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
        echo "Record has been created";
        echo nl2br(" \n $email, \n $password");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

// Close the database connection
$conn = null;
?>