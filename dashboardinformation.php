<?php 
session_start();

header('Content-Type: application/json');

// Include the database connection
require 'connection.php';



try {
    //REGISTER NEW DASHBOARD
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        define('TIMEZONE', 'Asia/Manila');
        date_default_timezone_set(TIMEZONE);
        // Handle log submission from ESP32
        
        $email = $_SESSION['email'];
        $ESP32SerialNumber = $_POST['ESP32SerialNumber'];
        $alertattempt = "NONE"; //green NO ALERT or CHECK LOGS
        // $alertlastattempt = "NULL"; //Date
        $doorlockstatus = "UNLOCKED"; // green locked or red unlocked
        // $doorlocklastunlocked = "NULL"; // Date
        $doorlocklastperson = "NULL"; //Check last person who unlocked
        $devicestatus = "OFFLINE"; //online or offline
        $devicessid = "NULL"; //SSID or wifi information

        // Update or insert the log into the database

        // INSERT INTO `dashboardinfo`(
        //     `ESP32SerialNumber`, 
        //     `email`, 
        //     `alert-attempt`, 
    
        //     `doorlock-status`, 
    
        //     `doorlock-lastperson`, 
        //     `device-status`, 
        //     `device-ssid`
        //     ) 
        //     VALUES (
        //     'SN-DA101A0F',
        //     'duck@duck.com',
        //     'NONE',
    
        //     'UNLOCKED',
    
        //     'NULL',
        //     'OFFLINE',
        //     'NULL'
        //     )
        $result = $conn->query("SELECT * FROM `dashboardinfo` WHERE `email` = '$email' AND `ESP32SerialNumber` = '$ESP32SerialNumber' ");
        

        if($result->num_rows > 0){
            echo json_encode(['status' => 'success', 'message' => 'already exist']);
            exit();
        }
        $stmt = $pdo->prepare("INSERT INTO `dashboardinfo`(
        `ESP32SerialNumber`, 
        `email`, 
        `alert-attempt`, 
       
        `doorlock-status`, 
      
        `doorlock-lastperson`, 
        `device-status`, 
        `device-ssid`
        ) 
        VALUES (
        :ESP32SerialNumber,
        :email,
        :alertattempt,
       
        :doorlockstatus,
    
        :doorlocklastperson,
        :devicestatus,
        :devicessid
        )");

        $stmt->execute([

            'ESP32SerialNumber' => $ESP32SerialNumber,
            'email' => $email,
            'alertattempt' => $alertattempt,
            // 'alertlastattempt' => $alertlastattempt,
            'doorlockstatus' => $doorlockstatus,
            // 'doorlocklastunlocked' => $doorlocklastunlocked,
            'doorlocklastperson' => $doorlocklastperson,
            'devicestatus' => $devicestatus,
            'devicessid' => $devicessid
        ]);

        echo json_encode([
            'status' => 'success',
            'ESP32SerialNumber' => $ESP32SerialNumber,
            'email' => $email,
            'alertattempt' => $alertattempt,
            // 'alertlastattempt' => $alertlastattempt,
            'doorlockstatus' => $doorlockstatus,
            // 'doorlocklastunlocked' => $doorlocklastunlocked,
            'doorlocklastperson' => $doorlocklastperson,
            'devicestatus' => $devicestatus,
            'device ssid' => $devicessid
        ]);
        exit();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Fetch the latest status for the frontend
        $stmt = $pdo->query("SELECT * FROM `dashboardinfo` WHERE `email` = '$email' AND `ESP32SerialNumber` = '$ESP32SerialNumber'");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $_GET['email'] ?? 'unknown';

        if ($row) {
            echo json_encode([
                'status' => 'success',
                'ESP32SerialNumber' => $ESP32SerialNumber,
                'email' => $email,
                'alertattempt' => $alertattempt,
                'alertlastattempt' => $alertlastattempt,
                'doorlockstatus' => $doorlockstatus,
                'doorlocklastunlocked' => $doorlocklastunlocked,
                'doorlocklastperson' => $doorlocklastperson,
                'devicestatus' => $devicestatus,
                'device ssid' => $devicessid
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No status found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}


?>