<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require('php/database.php');
require('php/hcaptcha.php');

//maak databaseverbinding met de gegevens uit database.php
//maak databaseverbinding met de gegevens uit database.php
$conn = new mysqli($servernaam, $gebruikersnaam, $wachtwoord, $database);
// Controleer de verbinding
if ($conn->connect_error) {
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

    $error="";

    $stmt = $conn->prepare("SELECT * FROM users WHERE (username=(?) OR email=(?))LIMIT 1");
    $stmt->bind_param("ss", $naam, $email);
    $stmt->execute();

    $records=$stmt->get_result();
    $stmt->close();

    $row = $records->fetch_assoc();


    $token = $_POST['h-captcha-response'];
    $responseData = captcha($token,$SECRET_KEY,$VERIFY_URL);

    if($responseData->success || true) {
        if(empty($_POST['gebruikersnaam'])) {
            $error = "Gebruikersnaam is required.";
        }
        else if(empty($_POST['wachtwoord'])) {
            $error = "Wachtwoord is required.";
        }
        else if(empty($_POST['email'])) {
            $error = "Email is required.";
        }
        
        if (mysqli_num_rows($records) == 0 && empty($error)){
        

            $stmt = $conn->prepare("INSERT INTO users(username, passwordhash, email) VALUES (?, ?, ?)");
            //$enabled = 1;
            $stmt->bind_param('sss', $naam, $pass, $email);
            $stmt->execute();
            $stmt->close();

            header("Location: signup.php");
            exit();
        }
        else {
            if(!empty($error)) {
            echo "<h1  style='color: red'>".$error."</h1>";
            }
            elseif ($naam === $row['username']) {
                echo "<h1 style='color: red;'>Username bezet.</h1>";
            }
            else {
                echo "<h1 style='color: red;'>Email bezet.</h1>";
            }
        }
    }
    else {
        echo "<h1 style='color: red;'>Doe de captcha opnieuw!</h1>";
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registreer</title>
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