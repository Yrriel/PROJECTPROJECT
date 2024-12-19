<?php 

require 'connection.php';

$generatedserialnumber = $_GET['serialNumber']; // Get serial number from the request
$fingerprintindex = $_GET['index'];
try {
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update the fingerprint index in the settings table
    $stmt = $pdo->prepare("SELECT * FROM `tablelistfingerprintenrolled` WHERE `ESP32SerialNumber` = :generatedserialnumber AND `indexFingerprint` = :fingerprintindex");
    $stmt->execute([
        'generatedserialnumber' => $generatedserialnumber,
        'fingerprintindex' => $fingerprintindex
    ]);

    $rowCount = $stmt->rowCount();

    if($rowCount == 0){
        echo json_encode(['status' => 'success', 'message' => 'Fingerprint index saved successfully']);
        exit();
    }

    echo json_encode(['status' => 'waiting', 'message' => 'Fingerprint index saved successfully']);
    exit();
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    exit();
}

?>