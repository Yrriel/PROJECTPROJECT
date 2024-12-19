<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $indexFingerprint = $_POST['index'];
    $ESP32SerialNumber = $_POST['ESP32SerialNumber'];

require 'connection.php';

try {
    // Establish PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update the optionesp32 value to enable fingerprint scanning
    $stmt = $pdo->prepare("UPDATE `settings` SET `optionesp32` = '3' WHERE id = '1'");
    //UPDATE `settings` SET `id`='1' WHERE `id`= '0'
    $stmt->execute();

    // Update the optionesp32 value in the settings table (id = 1)
    $stmt = $pdo->prepare("DELETE FROM `tablelistfingerprintenrolled` WHERE `indexFingerprint` = :indexFingerprint AND `ESP32SerialNumber` = :ESP32SerialNumber");

    // Execute the statement with the 'option' parameter
    $stmt->execute(['indexFingerprint' => $indexFingerprint, 'ESP32SerialNumber' => $ESP32SerialNumber]);

    // Return success status
    echo json_encode(['status' => 'success', 'indexFingerprint' => $indexFingerprint]);
    exit();
} catch (PDOException $e) {
    // Return error status and message
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit();
}
}   
?>
