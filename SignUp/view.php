<?php
require "conn.php";
require "UserDAO.php";
require "User.php";

$connection = new Conn("localhost", "root", "", "signup");
$userDAO = new UserDAO($connection);
$users = $userDAO->getUserDetails();
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0">
    <title>View Details</title>
</head>
<body class="display">
    <h2>User details</h2>
    <table class="userTable">
        <tr>
            <th>ID</th>
            <th>email</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user->getId(); ?></td>
                <td><?php echo $user->getEmail(); ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>