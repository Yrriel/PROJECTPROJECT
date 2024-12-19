<?php
session_start();


if (!isset($_GET["email"]) || !$_GET["token"]) {
    // exists and equal to link1
    header('Location: ../index.php');
    exit();
}

$email = $_GET["email"];
$token = $_GET["token"];
$transferemail = $_GET['transferemail'];

// Assuming you have a database connection setup
require 'connection.php';


    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the 'option' from the database
    $stmt = $pdo->prepare("SELECT `transferemail` FROM `verifications` WHERE `transfertoken` = :token");
    $stmt->execute(['token' => $token]);
    $number_of_rows = $stmt->rowCount(); 

    if ($number_of_rows > 0) {
        // $stmt = $pdo->prepare("DELETE FROM `verifications` WHERE `transfertoken` = :token");
        // $stmt->execute(['token' => $token]);

        // $conn->query("  UPDATE `tablelistowner` SET `email`= '$transferemail' WHERE `email` = '$email';
        //                 UPDATE `dashboardinfo` SET `email`= '$transferemail' WHERE `email` = '$email';
        //                 UPDATE `tablelistfingerprintenrolled` SET `email`= '$transferemail' WHERE `email` = '$email'");

        $stmt1 = $pdo->prepare("UPDATE `tablelistowner` SET `email`= :transferemail WHERE `email` = :email");
        $stmt1->execute(['email' => $email, 'transferemail' => $transferemail]);
    
        $stmt2 = $pdo->prepare("UPDATE `dashboardinfo` SET `email`= :transferemail WHERE `email` = :email");
        $stmt2->execute(['email' => $email, 'transferemail' => $transferemail]);
    
        $stmt3 = $pdo->prepare("UPDATE `tablelistfingerprintenrolled` SET `email`= :transferemail WHERE `email` = :email");
        $stmt3->execute(['email' => $email, 'transferemail' => $transferemail]);


        session_start();
        $_SESSION['email'] = $email;

    } else {
        echo '<script>
        alert("error. num rows = '.$number_of_rows.'");
        window.location.href="login.html";
    
        </script>';
 
    }


?>