<?php 
session_start();
// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the 'option' value passed in the POST request
    $email = $_SESSION['email'];
    $ESP32SerialNumber = $_POST['ESP32SerialNumber'];
    $indexFingerprint = $_POST['indexFingerprint'];

    // Database connection
    require 'connection.php';

    try {
        // Establish PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the optionesp32 value to enable fingerprint scanning
        $stmt = $pdo->prepare("UPDATE `tablelistfingerprintenrolled` SET `email`= :email, `indexFingerprint`=:indexFingerprint WHERE ESP32SerialNumber = :ESP32SerialNumber");   
        // $ASDAAW = ("INSERT INTO `tablelistfingerprintenrolled` (`indexFingerprint`, `email`) 
        // VALUES (:indexFingerprint, :email) WHERE `ESP32SerialNumber` = :ESP32SerialNumber");
        $stmt->execute([
        'ESP32SerialNumber' => $ESP32SerialNumber,
        'indexFingerprint' => $indexFingerprint,
        'email' => $email
        ]);

        // Return success status in JSON format
        echo json_encode([
            'status' => 'success',
            'message' => 'Fingerprint enrollment completed and ID inserted',
            'ESP32SerialNumber' => $ESP32SerialNumber,
            'indexFingerprint' => $indexFingerprint,
            'email' => $email
            ]);
            exit();
    } catch (PDOException $e) {
        // Return error status and message if the query fails
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit();
    }
}


?>