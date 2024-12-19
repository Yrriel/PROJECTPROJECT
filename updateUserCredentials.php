<?php
// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the values passed in the POST request
    $firstName = $_POST['firstName'] ?? null;
    $lastName = $_POST['lastName'] ?? null;
    $serialNumber = $_POST['serialNumber'] ?? null;

    // Validate input
    if (!$firstName || !$lastName || !$serialNumber) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
        exit;
    }

    // Database connection
    require 'connection.php';

    try {
        // Establish PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the record in the database
        $stmt = $pdo->prepare("
            UPDATE `tablelistowner` 
            SET `firstName` = :firstName, `lastName` = :lastName
            WHERE `ESP32SerialNumber` = :serialNumber
        ");
        $stmt->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'serialNumber' => $serialNumber
        ]);

        // Return success status in JSON format
        echo json_encode(['status' => 'success', 'message' => 'Record updated successfully.']);
    } catch (PDOException $e) {
        // Return error status and message if the query fails
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
