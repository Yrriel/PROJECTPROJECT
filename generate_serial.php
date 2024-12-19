<?php
session_start();
if(empty($_SESSION['email'])){
    header('location:login.php');
    die();
}

require 'connection.php'; // Ensure this file contains your database connection details
$targetEmail = $_SESSION['email']; //$_SESSION['email']; Dynamically set this in your application duck@duck.com xejoto1983@bawsny.com
header('Content-Type: application/json');

$result = $conn->query("SELECT `ESP32SerialNumber` FROM `tablelistowner` WHERE `email` = '$targetEmail'");
$objresult = $result->fetch_assoc();
if(strlen($objresult['ESP32SerialNumber']) !== 0){
    
    $generatedSerial = $objresult['ESP32SerialNumber'];
}
// Generate a unique serial number
else{
    $generatedSerial = "SN-" . strtoupper(bin2hex(random_bytes(4)));
}

try {
    // Replace this with the email of the target row


    // Prepare an UPDATE query to set the uid for the specific email
    $stmt = $conn->prepare("UPDATE tablelistowner SET uid = ? WHERE email = ?");
    
    // Bind the generated serial and the target email to the query
    $stmt->bind_param("ss", $generatedSerial, $targetEmail);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "serialNumber" => $generatedSerial]);
        } else {
            echo json_encode(["status" => "success", "message" => "No rows updated. already have serial number.",  "serialNumber" => $generatedSerial]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update UID."]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>
