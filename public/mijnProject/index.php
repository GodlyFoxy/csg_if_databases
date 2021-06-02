<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require('php/database.php');
require('php/hcaptcha.php');

//maak databaseverbinding met de gegevens uit database.php
$conn = new mysqli($servernaam, $gebruikersnaam, $wachtwoord, $database);
// Controleer de verbinding
if ($conn->connect_error) {
// Geef de foutmelding die de server teruggeeft en stop met de uitvoer van PHP (die)
die("Verbinding mislukt: " . mysqli_connect_error());
}
else {
// Dit gedeelte laat je normaliter weg, maar is hier ter illustratie toegevoegd
echo '<i>verbinding database succesvol</i>'.isset($_SESSION["user"]);
}

if(isset($_POST['submit'])) {

    $naam=$_POST['gebruikersnaam'];
    $pass=$_POST['wachtwoord'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE (username=(?) OR email=(?)) LIMIT 1");
    $stmt->bind_param('ss', $naam, $naam);
    $stmt->execute();

    $records=$stmt->get_result();
    $stmt->close();

    $row = $records->fetch_assoc();

    $passwordhash = $row["passwordhash"];
    $username = $row["username"];    

    //captcha data
    $token = $_POST['h-captcha-response'];
    $responseData = captcha($token, $SECRET_KEY, $VERIFY_URL);

    if($responseData->success) {
        if (mysqli_num_rows($records) == 1){//omzetten naar andere notatie
            if(password_verify($pass,$passwordhash)){
                if($row['enabled']) {
                    $_SESSION["user"]= $username;   
                    //UPDATE IP bij user, pakt alleen ip van gitpod, werkt wel lokaal
                    //$ip = "$_SERVER[REMOTE_ADDR]";
                    $stmt = $conn->prepare("UPDATE users SET lastIP=(?),lastLogin=(?) WHERE username=(?)");
                    $ip=$_SERVER['REMOTE_ADDR'];
                    $timedate = date('Y-m-d H:i:s'); //servertijd UTC0
                    $stmt->bind_param('sss',$ip, $timedate, $username);
                    $stmt->execute();

                    $stmt->close();

                    header("Location: index.php");
                    exit();
                }
                else {
                    echo "<h1 style='color: red;'>Account is gedeactiveerd!</h1>";
                }
            }
            else {
                echo "<h1 style='color: red;'>Gebruikersnaam, E-mail of wachtwoord onjuist!</h1>";
            }

        }
        else {
            echo "<h1 style='color: red;'>Gebruikersnaam, E-mail of wachtwoord onjuist!</h1>";
        }
    }
    else {
        echo "<h1 style='color: red;'>Doe de captcha opnieuw!</h1>";
    }
} 

if(isset($_POST['loguit'])) {
    


    echo "<h1 style='color: red;'>uitgelogd!</h1>";
    echo "<script type='text/javascript'>alert('uitgelogd!');</script>";
    session_destroy();
    header("Location: index.php");


}

if(isset($_POST['signup'])) {
    header("Location: signup.php");
}

if (isset($_SESSION["user"])) {
    echo "<h1 style='color: green;'>Welkom ".$_SESSION["user"]."</h1>";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Startpagina</title>
        <link rel="stylesheet" type="text/css" href="css/design.css">
        <!-- hcaptcha -->
        <script src="https://hcaptcha.com/1/api.js" async defer></script>

    </head>
    <body>
        <div id="container">
            <h1>
                <?php echo 'een <strong>klein</strong> stukje PHP<br>';?>
            </h1>
            <?php 
            if(!$_SESSION['user']) { echo'
            <form method="POST" action="">
                <label>Gebruiker</label>
                <input type="text" name="gebruikersnaam" placeholder="voer uw gebruikersnaam of email in..."><br><br>
                <label>Wachtwoord</label>
                <input type="password" name="wachtwoord" placeholder="Geef uw wachtwoord...">
                <input type="submit" name="submit"><br><br>

                <!-- hcaptcha -->
                <div class="h-captcha" data-sitekey="254a11ac-8587-4306-aa5b-52e6d9f2d227"></div>

                <input type="submit" name="signup" value="Geen account? Klik hier!">
            </form>';
            }
            else{
            echo'
            <form method="POST" action="">
                <input type="submit" name="loguit" value="log uit">
            </form>';}
            ?>
        </div>
    </body>
</html>