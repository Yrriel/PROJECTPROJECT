<?php


if (!isset($_GET["email"]) || !$_GET["token"]) {
    // exists and equal to link1
    header('Location: ../index.php');
    exit();
}

$email = $_GET["email"];
$token = $_GET["token"];



// Assuming you have a database connection setup
require 'connection.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the 'option' from the database
    $stmt = $pdo->prepare("SELECT `email` FROM `verifications` WHERE `token` = :token");
    $stmt->execute(['token' => $token]);
    $number_of_rows = $stmt->rowCount(); 

    if ($number_of_rows > 0) {
        $stmt = $pdo->prepare("DELETE FROM `verifications` WHERE `token` = :token");
        $stmt->execute(['token' => $token]);
        $stmt = $pdo->prepare("UPDATE `tablelistowner` SET `UID`='NEW' WHERE `email` = :email");
        $stmt->execute(['email'  => $email ]);
        session_start();
        $_SESSION['email'] = $email;
        echo '<script>
                    alert("Account set! Please change your password.");
                    window.location.href="login.html";
                </script>';
    } else {
        echo '<script>
        alert("error. num rows = '.$number_of_rows.'");
        window.location.href="login.html";
    
        </script>';
 
    }
} catch (PDOException $e) {
    // Handle error and return an error message in JSON format
    $response = array('error' => 'Error: ' . $e->getMessage());
    echo json_encode($response);
}

?>