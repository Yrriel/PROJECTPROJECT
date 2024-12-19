<?php
session_start();
require 'connection.php';

//token generator
$access_token = md5(uniqid().rand(1000000, 9999999));

$email = $_SESSION['email'];
$transferemail = $_POST['transferemail'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'config.php';

$mail = new PHPMailer();

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = MAILHOST;
$mail->Username = USERNAME;
$mail->Password = PASSWORD; 

$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom(SEND_FROM, SEND_FROM_NAME);

$mail->isHTML(true);                                  //Set email format to HTML
$mail->addAddress($transferemail);     //Add a recipient

$mail->Subject = "Transfer of Ownership";
$mail->Body = "Please click the link below to verify your account: <br><br>
                    <a href='http://192.168.100.21/cloudfingerprintproject/backendTransferConfirm.php?email=$email&token=$access_token&transferemail=$transferemail'>Register now</a>";

if($mail->send()){
    mysqli_query($conn, "INSERT INTO `verifications`(`transferemail`, `transfertoken`) VALUES ('$email','$access_token')");
    echo '<script>
            alert("Account pending! Please let them know the system sent an email.");
            window.location.href="login.html";
        </script>';
exit();
}
else{
    echo '<script>
            alert("Oops! Something went wrong. Please try again.");

        </script>';
exit();
}

?>