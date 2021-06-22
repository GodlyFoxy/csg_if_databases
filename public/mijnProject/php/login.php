<?php
require('database.php');
require('hcaptcha.php');
session_start();



if(isset($_POST['submit'])) {

    $naam=$_POST['gebruikersnaam'];
    $pass=$_POST['wachtwoord'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=(?) OR email=(?) LIMIT 1");
    $stmt->bind_param('ss', $naam, $naam);
    $stmt->execute();

    $records=$stmt->get_result();
    $stmt->close();

    $row = $records->fetch_assoc();

    $passwordhash = $row['passwordhash'];
    $username = $row['username'];    

    //captcha data
    $token = $_POST['h-captcha-response'];
    $responseData = captcha($token, $SECRET_KEY, $VERIFY_URL);

    if($responseData->success || true) {
        //omzetten naar andere notatie
        if (mysqli_num_rows($records) == 1){
            if(password_verify($pass,$passwordhash)){
                if($row['enabled']) {
                    $_SESSION['user']= $username;   
                    $stmt = $conn->prepare("UPDATE users SET lastIP=(?),lastLogin=(?) WHERE username=(?)");
                    //UPDATE IP bij user, pakt alleen ip van gitpod, werkt wel lokaal
                    $ip=$_SERVER['REMOTE_ADDR'];

                    //Tijdzonde gitpod is UTC0
                    $timedate = date('Y-m-d H:i:s'); 
                    $stmt->bind_param('sss',$ip, $timedate, $username);
                    $stmt->execute();

                    $stmt->close();

                    header("Location: ../index.php");
                    exit();
                }
                else {
                    //Account gedeactiveerd
                    $_SESSION["notification"] = 1;
                    header("Location: ../index.php");
                }
            }
            else {
                //Wachtwoord onjuist
                $_SESSION["notification"] = 3;
                header("Location: ../index.php");
            }
        }
        else {
            //Gebruikersnaam of email onjuist
            $_SESSION["notification"] = 4;
            header("Location: ../index.php");
        }
    }
    else {
        //Doe de captcha opniew!
        $_SESSION["notification"] = 2;
        header("Location: ../index.php");
    }
} 