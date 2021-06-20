<?php

error_reporting(E_ALL & ~E_NOTICE);
session_start();

if(isset($_POST['loguit'])) {
    
    session_destroy();
    header("Location: index.php");
}

if(isset($_POST['signup'])) {
    header("Location: signup.php");
}

if (isset($_SESSION["user"])) {
    echo "<h1 style='color: green;'>Welkom ".$_SESSION["user"]."</h1>";
}

if (isset($_SESSION["error"])) {
    switch ($_SESSION["error"]) {
    // Review
    case 'R0':
        echo "Review verzonden.";
        break;
    // Algemeen
    case 1:
        echo "Account gedeactiveerd.";
        break;
    case 2:
        echo "Doe de captcha opnieuw";
        break;
    // Login
    case 3:
        echo "Wachtwoord onjuist!";
        break;
    case 4:
        echo "Gebruikersnaam of E-mail onjuist.";
        break;
    // Registratie
    case 5:
        echo "Doe de captcha opnieuw";
        break;
    }
    unset($_SESSION['error']);
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
            if(!isset($_SESSION['user'])) { 
                echo <<<HTML
                <form method="POST" action="php/login.php">
                    <label>Gebruiker</label>
                    <input type="text" name="gebruikersnaam" placeholder="voer uw gebruikersnaam of email in..." required><br><br>
                    <label>Wachtwoord</label>
                    <input type="password" name="wachtwoord" placeholder="Geef uw wachtwoord..." required>
                    <input type="submit" name="submit"><br><br>
                    <!-- hcaptcha -->
                    <div class="h-captcha" data-sitekey="254a11ac-8587-4306-aa5b-52e6d9f2d227"></div>
                </form>  
                <form method="POST" action="">
                    <input type="submit" name="signup" value="Geen account? Klik hier!">
                </form>  
                HTML;
            }
            else {
                echo <<<HTML
                <form method="POST" action="php/send_review.php">
                <!-- http://web.archive.org/web/20161123092558/http://rog.ie/blog/css-star-rater -->
                    <strong class="choice">Choose a rating</strong><br>
                    <span class="star-rating">
                        <input type="radio" name="rating" value="1"><i></i>
                        <input type="radio" name="rating" value="2"><i></i>
                        <input type="radio" name="rating" value="3"><i></i>
                        <input type="radio" name="rating" value="4"><i></i>
                        <input type="radio" name="rating" value="5"><i></i>
                    </span> <br><br>
                    <input type="text" name="comment" placeholder="Type hier uw review...">
                    <input type="submit" name="review" value="Verstuur review"><br><br>
                    <div class="h-captcha" data-sitekey="254a11ac-8587-4306-aa5b-52e6d9f2d227"></div>
                </form>
                <form method="POST" action="">
                    <input type="submit" name="loguit" value="log uit">
                </form>
                HTML;
            }?>
        </div>
    </body>
</html>