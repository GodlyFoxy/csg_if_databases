<?php

error_reporting(E_ALL & ~E_NOTICE);
session_start();
require('php/database.php');


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

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=(?) LIMIT 1");
    $stmt->bind_param('ss', $naam, $naam);
    $stmt->execute();

    $records=$stmt->get_result();
    $stmt->close();

    $row = $records->fetch_assoc();

    $passwordhash = $row["passwordhash"];
    $username = $row["username"]; 
    $email = $row["email"];   
    $date = $row["lastLogin"];

    //omzetten naar andere notatie
    if (mysqli_num_rows($records) == 0){
        if(password_verify($pass,$passwordhash)){
            $_SESSION["user"]= $username;   
            $stmt = $conn->prepare("UPDATE users SET username=(?) WHERE username=(?)");

            $stmt->bind_param('ss',$newusername, $username);
            $stmt->execute();

            $stmt->close();

            header("Location: index.php");
            exit();
        }
        else {
            echo "<h1 style='color: red;'>Wachtwoord onjuist!</h1>";//
        }
    }
    else {
        echo "<h1 style='color: red;'>Gebruikersnaam of E-mail onjuist.</h1>";
    }
} 

if(isset($_POST['loguit'])) {
    


    echo "<h1 style='color: red;'>uitgelogd!</h1>";
    echo "<script type='text/javascript'>alert('uitgelogd!');</script>";
    session_destroy();
    header("Location: index.php");


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

    </head>
    <body>
        <div id="container">
            <h1>
                <?php echo 'Laatste login op: <strong>'.$date.'</strong><br>';?>
            </h1>
            <form method="POST" action="">
                <label>Gebruikersnaam veranderen</label>
                <input type="text" name="gebruikersnaam" placeholder="<?php echo $_SESSION['user']; ?> value="<?php echo $_SESSION['user']; ?>"><br><br>
                <label><h2>Wachtwoord veranderen:</h2></label>
                <input type="password" name="wachtwoord" placeholder="Geef uw huidige wachtwoord..."><br><br>
                <input type = "password" name="newWachtwoord" placeholder="Geeft uw nieuwe wachtwoord...">
                <input type="submit" name="submit"><br><br>
                <input type="submit" name="loguit" value="log uit">
        </div>
    </body>
</html>