<?php

session_start();
// if(empty($_SESSION['email'])){
//     header('location:login.php');
//     die();
// }

// $isAccountNew = $_SESSION['uid'];
// $email = $_SESSION['email'];

// if($isAccountNew == "NEW"){
//     header("Location:newacount2.php");
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/dashboard-style.css">
    <style>
        p button{
            text-decoration: none;
            color: white;
            border: none;
            
        }
    </style>
</head>
<body>
    <div class="half-circle"></div>
    <div class="headerwrapper">
        <div class="header">
            <nav class="dash-nav">
                <a class="button-menu-href" href="dashboard.php"><img class="button-menu" src="src/svg/icon-homeicon.svg" alt=""></a>
                <a class="button-profile-href" href="login.html"><img class="button-profile" src="src/svg/profile-icon.svg" alt="">logout</a>
            </nav>
        </div>
        <div class="section">
            <div class="wrapper">
                <div class="profile-container">
                    <span class="profile-container-span">
                        <img class="profile-picture" src="src/img/profile-sample.jpeg" alt="">
                        <span class="profile-text-box">
                            <h1>Dashboard</h1>
                            <p>No Alerts</p>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="contentwrapper"> -->
        <div class="message-alert-container">
            <div class="message-alert">
                
                <form action="backendTransfer.php" method="post" class="status-container  dashboard-information">
                    <h2>Transfer Ownership</h2>
                    <div class="gap-row">
                        <div class="device-status-container">
                            <img class="icon-device-status" src="src/svg/icon-last-person.svg" alt="" srcset="">
                            <p>Transfer to</p><input type="text" placeholder="Email" name="transferemail"></p>
                        </div>
                        <div class="device-status-container">
                            <p><button class="doorlock-unlocked" id="device-status">Transfer Ownership</button></p>
                        </div>

                    </div>
                </form>
                
                <!-- <p>Hola. Using this ui for login page for testing purposes.</p>
                <p>Can't interact with other buttons. Only Fingerprint button works</p> -->
            </div>
        </div>
    

    <!-- </div> -->
</body>
<script>
    

</script>
</html>