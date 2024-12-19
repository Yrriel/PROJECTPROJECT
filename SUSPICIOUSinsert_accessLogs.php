<?php 
header('Content-Type: application/json');
session_start();
// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    date_default_timezone_set('Asia/Manila');
    $dateAndTime = date('Y-m-d H:i:s');
    // Get the 'option' value passed in the POST request
    // $name = $_POST['name'] ?? NULL;

    $ESP32SerialNumber = $_POST['ESP32SerialNumber'];
    $typee = $_POST['type'];



    // Database connection
    require 'connection.php';

    try {

        // Establish PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $pdo->prepare("INSERT INTO `tablelistauditlogs` (`ESP32SerialNumber`, `DATE`, `TYPE`, `DESCRIPTION`) 
        VALUES (:ESP32SerialNumber, :DATE, :typee, 'Tried to access') ");
        $stmt->execute([
        'ESP32SerialNumber' => $ESP32SerialNumber,
        'DATE' => $dateAndTime,
        'typee' => $typee
        ]);

        // Return success status in JSON format
        echo json_encode(['status' => 'success','message' => 'DONE DB']);
            exit();
    } catch (PDOException $e) {
        // Return error status and message if the query fails
        echo json_encode(['status' => 'error', 'message' => $e->getMessage(), 'name' => $indexFingerprint, 'ESP32SerialNumber' => $ESP32SerialNumber]);
        exit();
    }
    
}


?>