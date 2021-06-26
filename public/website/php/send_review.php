<?php
require('database.php');
require('hcaptcha.php');
session_start();

$gameID = htmlspecialchars($_GET["gameID"]);

if(!is_numeric($gameID) || ($gameID < 1 || $gameID > 4)) {
    $_SESSION["alert"] = 'R0';
    header("Location:".$_SERVER['HTTP_REFERER']);
}

if(isset($_POST['review']) && isset($gameID)) {
    $comment=$_POST['comment'];
    $username=$_SESSION['user']; 
    $rating=$_POST['rating'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=(?) LIMIT 1");
    $stmt->bind_param('s', $username);
    $stmt->execute();

    $records=$stmt->get_result();
    $stmt->close();

    $row = $records->fetch_assoc();

    $userID = $row['userID'];

    //captcha data
    $token = $_POST['h-captcha-response'];
    $responseData = captcha($token, $SECRET_KEY, $VERIFY_URL);

    if($responseData->success || true) {
        //omzetten naar andere notatie
        if($row['enabled']) {
                $stmt = $conn->prepare("INSERT INTO reviews(userID, gameID, rating, comment) VALUES (?, ?, ?, ?)");
                $comment=$_POST['comment'];
                $stmt->bind_param('iiis',$userID, $gameID, $rating, $comment);
                $stmt->execute();

                $stmt->close();
                //Review verzonden
                $_SESSION["alert"] = 'R0';
                header("Location:".$_SERVER['HTTP_REFERER']);
                exit();
        }
        else {
                //Account is gedeactiveerd!
                $_SESSION["alert"] = 1;
                header("Location:".$_SERVER['HTTP_REFERER']);
        } 
    }
    else {
        //Doe de captcha opnieuw!
        $_SESSION["alert"] = 2;
        header("Location:".$_SERVER['HTTP_REFERER']);
    }
} 