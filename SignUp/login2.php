<?php
session_start();
include 'connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\xampp\htdocs\IAP\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\IAP\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\IAP\PHPMailer\src\SMTP.php';

if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['email'] = $email;

    try {
        // Use a prepared statement to retrieve the user by email
        $stmt = $conn->prepare("SELECT * FROM signup WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data && password_verify($password, $data['password'])) {
            $otp = rand(100000, 999999);
            $otpExpiry = time() + 300;
            $subject = "Your OTP for Login";
            $message = "Your OTP is: $otp";

            // Send OTP email
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'victor.lonolongo@gmail.com'; // Host email
            $mail->Password = ''; // App password of your host email
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->isHTML(true);
            $mail->setFrom('iap.e@gmail.com', 'IAP E'); // Sender's email & name
            $mail->addAddress($email, $data['name']); // Receiver's email and name
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();

            // Update the user's OTP and expiry in the database
            $updateStmt = $pdo->prepare("UPDATE signup SET otp = :otp, otp_expiry = :otp_expiry WHERE id = :id");
            $updateStmt->execute([
                'otp' => $otp,
                'otp_expiry' => $otp_expiry,
                'id' => $data['id']
            ]);

            $_SESSION['temp_user'] = ['id' => $data['id'], 'otp' => $otp];
            header("Location: otp_verification.php");
            exit();
        } else {
            ?>
            <script>
                alert("Invalid Email or Password. Please try again.");
                function navigateToPage() {
                    window.location.href = 'login.php';
                }
                window.onload = function() {
                    navigateToPage();
                }
            </script>
            <?php
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>