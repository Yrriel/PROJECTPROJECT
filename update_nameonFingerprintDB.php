<?php 
session_start();
// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the 'option' value passed in the POST request
    $name = $_POST['name'];
    $serialNumber = $_POST['ESP32SerialNumber'];
    $index = $_POST['index'];


    // Database connection
    require 'connection.php';

    try {
        // Establish PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the optionesp32 value to enable fingerprint scanning
        // UPDATE `tablelistfingerprintenrolled` SET `name`='MrDuck' WHERE ESP32SerialNumber = 'SN-DA101A0F'
        $stmt = $pdo->prepare("UPDATE `tablelistfingerprintenrolled` SET `name`= :name WHERE ESP32SerialNumber = :serialNumber AND `indexFingerprint` = :index");   

        $stmt->execute([
        'name' => $name,
        'serialNumber' => $serialNumber,
        'index' => $index
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