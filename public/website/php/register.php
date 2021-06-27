<?php

include_once('preload.php');
require('database.php');
require('hcaptcha.php');

if(isset($_POST['submit'])) {

    $name=$_POST['username'];
    $password=password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email=$_POST['email'];

    $error="";

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=(?) OR email=(?) LIMIT 1");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();

    $records=$stmt->get_result();
    $stmt->close();

    $row = $records->fetch_assoc();


    $token = $_POST['h-captcha-response'];
    $responseData = captcha($token,$SECRET_KEY,$VERIFY_URL);

    if($responseData->success || true) {
        if(empty($_POST['username'])) {
            $error = "Gebruikersnaam is required.";
            $_SESSION["alert"] = 5;
            header("Location:".$_SERVER['HTTP_REFERER']);
        }
        else if(!preg_match("/^[a-zA-Z0-9]([._-]|[a-zA-Z0-9]){4,19}$/",$_POST['username'])) {
            $error = "Voldoet niet aan de voorwaarden";
            $_SESSION["alert"] = 6;
            header("Location:".$_SERVER['HTTP_REFERER']);
        }
        else if(empty($_POST['password'])) {
            $error = "Wachtwoord is required.";
            $_SESSION["alert"] = 7;
            header("Location:".$_SERVER['HTTP_REFERER']);
        }
        else if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d).*[A-Za-z\d*.!@$%^&(){}[\]:;<>,.?\/~_+-=|\\]{8,}$/",$_POST['password'])) {
            $error = "Voldoet niet aan de voorwaarden.";
            $_SESSION["alert"] = 8;
            header("Location:".$_SERVER['HTTP_REFERER']);
        }
        else if(empty($_POST['email'])) {
            $error = "Email is required.";
            $_SESSION["alert"] = 9;
            header("Location:".$_SERVER['HTTP_REFERER']);
        }
        
        if (mysqli_num_rows($records) == 0 && empty($error)){
        

            $stmt = $conn->prepare("INSERT INTO users(username, passwordhash, email) VALUES (?, ?, ?)");
            //$enabled = 1;
            $stmt->bind_param('sss', $name, $password, $email);
            $stmt->execute();
            $stmt->close();

            header("Location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
        else {
            if(!empty($error)) {
            echo "<h1  style='color: red'>".$error."</h1>";
            }
            elseif ($naam === $row['username']) {
                echo "<h1 style='color: red;'>Username bezet.</h1>";
                $_SESSION["alert"] = 10;
                header("Location:".$_SERVER['HTTP_REFERER']);
            }
            else {
                echo "<h1 style='color: red;'>Email bezet.</h1>";
                $_SESSION["alert"] = 11;
                header("Location:".$_SERVER['HTTP_REFERER']);
            }
        }
    }
    else {
        echo "<h1 style='color: red;'>Doe de captcha opnieuw!</h1>";
        $_SESSION["alert"] = 2;
        header("Location:".$_SERVER['HTTP_REFERER']);
        
    }
}

// END OF FILE