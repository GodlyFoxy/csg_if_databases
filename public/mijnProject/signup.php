<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require('php/database.php');

//maak databaseverbinding met de gegevens uit database.php
$DBverbinding = mysqli_connect($servernaam, $gebruikersnaam, $wachtwoord, $database);
// Controleer de verbinding
if (!$DBverbinding) {
// Geef de foutmelding die de server teruggeeft en stop met de uitvoer van PHP (die)
die("Verbinding mislukt: " . mysqli_connect_error());
}
else {
// Dit gedeelte laat je normaliter weg, maar is hier ter illustratie toegevoegd
echo '<i>verbinding database succesvol</i>';
}

if(isset($_POST['submit'])) {
    $naam=$_POST['gebruikersnaam'];
    $pass=password_hash($_POST['wachtwoord'], PASSWORD_BCRYPT);
    $email=$_POST['email'];
    $sql="SELECT * FROM users WHERE (username='".$naam."' OR email='".$email."')LIMIT 1";
    $records = mysqli_query($DBverbinding, $sql);
    if (mysqli_num_rows($records) == 0){
       

        $query = "INSERT INTO users(username, passwordhash, email, enabled) VALUES ('".$naam."', '".$pass."', '".$email."', 1)";
        mysqli_query($DBverbinding, $query);
        header("Location: signup.php");
        exit();
    }
    else {
        echo "<h1 style='color: red;'>Gebruikersnaam bezet of email al gebruikt.</h1>";
    }
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
            <?php if(!$_SESSION['user']) { echo'
                <form method="POST" action="">
                    <label>Gebruiker</label>
                    <input type="text" name="gebruikersnaam" placeholder="Kies een gebruikersnaam..."><br><br>
                    <label>Wachtwoord</label>
                    <input type="password" name="wachtwoord" placeholder="Geef uw wachtwoord..."><br><br>
                    <label>email</label>
                    <input type="text" name="email" placeholder="Geef uw email...">
                    <input type="submit" name="submit" value="registreer"><br><br>

                    <!-- hcaptcha -->
                    <div class="h-captcha" data-sitekey="254a11ac-8587-4306-aa5b-52e6d9f2d227"></div>
                
                    </form>';
            }
            else {
                echo "<h1 style='color: red;'>U heeft al een account en u bent al ingelogd.</h1>";
            }?>
        </div>
    </body>
</html>