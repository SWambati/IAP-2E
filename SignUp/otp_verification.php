<?php
session_start();

require 'connection.php'; 

if (!isset($_SESSION['temp_user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = $_POST['otp'];
    $stored_otp = $_SESSION['temp_user']['otp'];
    $user_id = $_SESSION['temp_user']['id'];

    try {
        
        $stmt = $pdo->prepare("SELECT * FROM signup WHERE id = :id AND otp = :otp");
        $stmt->execute([
            'id' => $user_id,
            'otp' => $user_otp
        ]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $otp_expiry = strtotime($data['otp_expiry']);
            if ($otp_expiry >= time()) {
                $_SESSION['user_id'] = $data['id']; // Login the user
                unset($_SESSION['temp_user']); // Clear temporary session
                header("Location: dashboard.php");
                exit();
            } else {
                ?>
                <script>
                    alert("OTP has expired. Please try again.");
                    function navigateToPage() {
                        window.location.href = 'login.php';
                    }
                    window.onload = function() {
                        navigateToPage();
                    }
                </script>
                <?php
            }
        } else {
            echo "<script>alert('Invalid OTP. Please try again.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style type="text/css">
        #container{
            border: 1px solid black;
            width: 400px;
            margin-left: 400px;
            margin-top: 50px;
            height: 330px;
        }
        form{
            margin-left: 50px;
        }
        p{
            margin-left: 50px;
        }
        h1{
            margin-left: 50px;
        }
        input[type=number]{
            width: 290px;
            padding: 10px;
            margin-top: 10px;

        }
        button{
            background-color: orange;
            border: 1px solid orange;
            width: 100px;
            padding: 9px;
            margin-left: 100px;
        }
        button:hover{
            cursor: pointer;
            opacity: .9;
        }
    </style>
</head>
<body>
    <div id="container">
        <h1>Two-Step Verification</h1>
        <p>Enter the 6 Digit OTP Code that has been sent <br> to your email address: <?php echo $_SESSION['email']; ?></p>
        <form method="post" action="otp_verification.php">
            <label style="font-weight: bold; font-size: 18px;" for="otp">Enter OTP Code:</label><br>
            <input type="number" name="otp" pattern="\d{6}" placeholder="Six-Digit OTP" required><br><br>
            <button type="submit">Verify OTP</button>
        </form>
    </div>
</body>
</html>
