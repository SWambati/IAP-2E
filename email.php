<?php
use PHPMailer\PHPMailer\PHPMailer;

require 'C:\xampp\htdocs\IAP\PHPMailer\vendor\autoload.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'example@gmail.com';
$mail->Password = '';
$mail->SMTPSecure = 'tls'; 
$mail->Port = 587;

$mail->setFrom('example@gmail.com', 'IAP2E');
$mail->addAddress('example@gmail.com');
$mail->Subject = 'Test Email';
$mail->Body = 'This email tests the use of PHPMailer plugin.';
$mail->send();
?>