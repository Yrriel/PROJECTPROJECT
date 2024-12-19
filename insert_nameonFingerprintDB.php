<?php 
session_start();

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the 'option' value passed in the POST request
    $name = $_POST['firstName'] . "" . $_POST['lastName'];
    $serialNumber = $_POST['serialNumber'];
    $email = $_SESSION['email'];
    $index = $_POST['index'];


    // Database connection
    require 'connection.php';

    try {
        // Establish PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the optionesp32 value to enable fingerprint scanning
        // UPDATE `tablelistfingerprintenrolled` SET `name`='MrDuck' WHERE ESP32SerialNumber = 'SN-DA101A0F'
        $stmt = $pdo->prepare("INSERT INTO `tablelistfingerprintenrolled`(`email`, `ESP32SerialNumber`, `indexFingerprint`, `name`) VALUES (:email, :ESP32SerialNumber, :indexFingerprint, :name)");   
        // $ASDAAW = ("INSERT INTO `tablelistfingerprintenrolled` (`indexFingerprint`, `email`) 
        // VALUES (:indexFingerprint, :email) WHERE `ESP32SerialNumber` = :ESP32SerialNumber");
        $stmt->execute([
        'email' => $email,
        'indexFingerprint' => $index,
        'name' => $name,
        'ESP32SerialNumber' => $serialNumber
        ]);

        // Return success status in JSON format
        echo json_encode(['status' => 'success','message' => 'DONE DB']);
            exit();
    } catch (PDOException $e) {
        // Return error status and message if the query fails
        echo json_encode(['status' => 'error', 'message' => $e->getMessage(), 'name' => $name, 'ESP32SerialNumber' => $serialNumber]);
        exit();
    }
}


?>