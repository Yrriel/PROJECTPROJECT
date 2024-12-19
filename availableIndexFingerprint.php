<?php
session_start();
require 'connection.php';
$deviceserial = $_SESSION['ESP32SerialNumber'];
$maxLoops = 50; // Maximum number of iterations
$noRowsAtLoop = 1; // Variable to store the loop count if no rows are found

// Start the loop
for ($i = 1; $i <= $maxLoops; $i++) {
    // Query to fetch rows for the current iteration
    $query = "SELECT * FROM `tablelistfingerprintenrolled` WHERE `ESP32SerialNumber` = '$deviceserial' AND `indexFingerprint` = '$i'";
    $result = $conn->query($query);

    // Check if rows exist
    if ($result->num_rows == 0) {
        $noRowsAtLoop = $i; // Save the current loop count
        break; // Exit the loop
    }
}

// Prepare the response
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'noRowsAtLoop' => $noRowsAtLoop, // Return the iteration number
    'sERIALNUMBER' => $deviceserial
]);

?>
