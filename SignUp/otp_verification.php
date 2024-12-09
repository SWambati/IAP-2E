<?php
require 'Database.php';
require 'EmailService.php';
require 'UserAuth.php';

$db = new Database();
$emailService = new EmailService();
$userAuth = new UserAuth($db, $emailService);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_otp'])) {
    $otp = trim($_POST['otp']);

    try {
        if ($userAuth->verifyOTP($otp)) {
            header("Location: dashboard.php");
            exit();
        }
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>
<!-- HTML Form -->
<form method="POST" action="">
    <label>Enter OTP:</label>
    <input type="text" name="otp" required>
    <button type="submit" name="verify_otp">Verify OTP</button>
</form>
