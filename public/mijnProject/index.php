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
    $pass=$_POST['wachtwoord'];
    $sql="SELECT * FROM users WHERE (username='".$naam."' OR email='".$naam."')AND password='".$pass."' LIMIT 1";
    $records = mysqli_query($DBverbinding, $sql);
    if (mysqli_num_rows($records) == 1){
        $_SESSION["user"]= mysqli_fetch_array($records)["username"];   
        //UPDATE IP bij user, pakt alleen ip van gitpod, werkt wel lokaal
        $query = "UPDATE users SET lastIP='$_SERVER[REMOTE_ADDR]' WHERE username='$_SESSION[user]'";
        mysqli_query($DBverbinding, $query);
        header("Location: index.php");
        exit();
    }
    else {
        echo "<h1 style='color: red;'>Gebruikersnaam of wachtwoord onjuist</h1>";
    }
}
if(isset($_POST['loguit'])) {
    
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
else {
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Startpagina</title>
        <link rel="stylesheet" type="text/css" href="css/design.css">
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