<?php
session_start();
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            require 'connection.php';
            $loggedMail = $_SESSION['email'];
            $email = $_POST['email'] ?? "none";
            $password = $_POST['password'] ?? "none";

            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                mysqli_query($conn, "UPDATE `tablelistowner` SET `email`='$email' WHERE `email` = '$loggedMail'");
                echo '<script>
                alert("Changed email: '.$password.'");
           
                </script>';
            }
            if($password !== "none"){
                $conn->query("UPDATE `tablelistowner` SET `password`='$password' WHERE `email` = '$loggedMail'");
                echo '<script>
                alert("Changed Password: '.$password.'");
           
                </script>';
            }
            echo '<script>
            alert("Saved changes. Please login again. : EMAIL : '.$loggedMail.' Password: '.$password.'");
            window.location.href="login.html";
            </script>';
            exit();
        }


?>