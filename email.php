<?php
use PHPMailer\PHPMailer\PHPMailer;

require 'C:\xampp\htdocs\IAP\PHPMailer\vendor\autoload.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'bibo.jimbo21@gmail.com';
$mail->Password = 'tcrexjpdovcatycv';
$mail->SMTPSecure = 'tls'; 
$mail->Port = 587;

$mail->setFrom('bibo.jimbo21@gmail.com', 'IAP2E');
$mail->addAddress('sylvia.wambati@gmail.com');
$mail->Subject = 'Test Email';
$mail->Body = 'This email tests the use of PHPMailer plugin.';
$mail->send();
?>