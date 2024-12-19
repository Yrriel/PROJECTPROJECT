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
    $indexFingerprint = $_POST['index'];
    $lastpersonName;


    // Database connection
    require 'connection.php';

    try {

        // Establish PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $pdo->prepare("SELECT `name` FROM `tablelistfingerprintenrolled` WHERE `indexFingerprint` = :indexFingerprint");
        $stmt->execute(['indexFingerprint' => $indexFingerprint]);
        $lastperson = $stmt->fetch(PDO::FETCH_ASSOC);
        $lastpersonName = $lastperson['name']; // Default to 'Unknown' if not found


        $stmt = $pdo->prepare("INSERT INTO `tablelistauditlogs` (`indexFingerprint`, `name`, `ESP32SerialNumber`, `DATE`, `TYPE`, `DESCRIPTION`) 
        VALUES (:indexFingerprint, :name, :ESP32SerialNumber, :DATE,'Access', 'Unlocks facility') ");
        $stmt->execute([
        'indexFingerprint' => $indexFingerprint,
        'name' => $lastpersonName,
        'ESP32SerialNumber' => $ESP32SerialNumber,
        'DATE' => $dateAndTime
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