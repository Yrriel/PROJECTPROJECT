<?php
session_start();
header('Content-Type: application/json');

// Include the database connection
require 'connection.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /* 
        POST what data?
        'sendThistoPage' => $column
        updates to table dashboardinfo
    */

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle log submission from ESP32
        date_default_timezone_set('Asia/Manila');
        $dateAndTime = date('Y-m-d H:i:s');
    
        $whatToSend = $_POST['infodata'];
        $whereToSend = $_POST['sendThistoPage'];
        $fromthisDevice = $_POST['serialnumber'];

        //send last Open
        if($whereToSend == 'doorlock-lastperson'){
            $stmt = $pdo->prepare("SELECT `name` FROM `tablelistfingerprintenrolled` WHERE indexFingerprint = :indexFingerprint");
            $stmt->execute(['indexFingerprint' => $whatToSend]);
            $lastperson = $stmt->fetch(PDO::FETCH_ASSOC);
            $lastpersonName = $lastperson['name']; // Default to 'Unknown' if not found

            $stmt = $pdo->prepare("UPDATE `dashboardinfo` SET `doorlock-lastperson` = :lastpersonName, `doorlock-lastunlocked` = :dateAndTime WHERE `ESP32SerialNumber` = :ESP32SerialNumber");
            $stmt->execute(['lastpersonName' => $lastpersonName, 'ESP32SerialNumber' => $fromthisDevice, 'dateAndTime' => $dateAndTime]);
        }
        //send ssid info
        if($whereToSend == 'device-ssid'){
            $stmt = $pdo->prepare("UPDATE `dashboardinfo` SET `device-ssid` = :infodata, `device-status` = 'online' WHERE `ESP32SerialNumber` = :ESP32SerialNumber");
            $stmt->execute(['infodata' => $whatToSend, 'ESP32SerialNumber' => $fromthisDevice]);
        }
        //send doorlock-status
        if($whereToSend == 'doorlock-status'){
            $stmt = $pdo->prepare("UPDATE `dashboardinfo` SET `doorlock-status` = :doorlockstatus WHERE `ESP32SerialNumber` = :ESP32SerialNumber");
            $stmt->execute(['doorlockstatus' => $whatToSend, 'ESP32SerialNumber' => $fromthisDevice]);
        }
        if($whereToSend == 'alert-attempt'){
            $stmt = $pdo->prepare("UPDATE `dashboardinfo` SET `alert-attempt` = :infodata, `alert-lastattempt` = :dateAndTime WHERE `ESP32SerialNumber` = :ESP32SerialNumber");
            $stmt->execute(['infodata' => $whatToSend, 'ESP32SerialNumber' => $fromthisDevice, 'dateAndTime' => $dateAndTime]);
            //INSERT INTO `tablelistauditlogs`(`ESP32SerialNumber`, `DATE`, `TYPE`, `DESCRIPTION`) VALUES ('[value-3]','[value-4]','[value-5]','[value-6]')
            $stmt = $pdo->prepare("INSERT INTO `tablelistauditlogs`(`name`,`ESP32SerialNumber`, `DATE`, `TYPE`, `DESCRIPTION`) VALUES ('Intruder',:ESP32SerialNumber,:dateAndTime,:TYPE,'Attempted to Open')");
            $stmt->execute(['TYPE' => $whatToSend, 'ESP32SerialNumber' => $fromthisDevice, 'dateAndTime' => $dateAndTime]);
        }


        echo json_encode(['status' => 'success', 'message' => 'Log updated successfully']);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_SESSION['email'])) {
            echo json_encode(['status' => 'error', 'message' => 'Email is required']);
            exit();
        }
        $email = $_SESSION['email']; // or $email = $_POST['email']; if using POST
        // Fetch the latest status for the frontend
        $stmt = $pdo->prepare("SELECT * FROM `dashboardinfo` WHERE `email` = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if($row['device-status'] == "ONLINE"){
                $stmt = $pdo->prepare("UPDATE `dashboardinfo` SET `device-status` = 'OFFLINE', `device-ssid` = 'OFFLINE' WHERE `email` = :email");
                $stmt->execute(['email' => $email]);
            }

            echo json_encode([
                'status' => 'success',
                'device-status' => $row['device-status'],
                'device-ssid' => $row['device-ssid'],
                'alert-attempt' => $row['alert-attempt'],
                'alert-lastattempt' => $row['alert-lastattempt'],
                'doorlock-status' => $row['doorlock-status'],
                'doorlock-lastunlocked' => $row['doorlock-lastunlocked'],
                'doorlock-lastperson' => $row['doorlock-lastperson']
            ]);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No status found']);
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
