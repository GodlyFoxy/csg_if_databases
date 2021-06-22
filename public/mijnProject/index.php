<?php
include_once('php/preload.php');
include('php/averageRating.php');
error_reporting(E_ALL & ~E_NOTICE);
session_start();

$pageTitle = "Startpagina";

if(isset($_POST['signup'])) {
    header("Location: signup.php");
}

if (isset($_SESSION["user"])) {
    echo "<h1 style='color: green;'>Welkom ".$_SESSION["user"]."</h1>";
}

if (isset($_SESSION["notification"])) {
    switch ($_SESSION["notification"]) {
    // Review
    case 'R0':
        echo "Review verzonden.";
        break;
    // Loguit
    case 'L0':
        echo "Uitgelogd.";
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
    unset($_SESSION['notification']);
}
include $template['header']
?>
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
            $avgRating = getAverage(6);
            echo <<<HTML
            <form method="POST" action="php/send_review.php">
            <!-- http://web.archive.org/web/20161123092558/http://rog.ie/blog/css-star-rater -->
                <strong class="choice">Choose a rating</strong><br>
                <select id="rating" name="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <script type="text/javascript"> 
                    $(function() {
                        $('#rating').barrating('show', {
                            theme: 'fontawesome-stars-o',
                            initialRating: $avgRating
                        });
                    });
                </script>
                <br>
                <textarea rows="5" name="comment" placeholder="Type een review..."></textarea>
                <input type="submit" name="review" value="Verstuur review"><br><br>
                <div class="h-captcha" data-sitekey="254a11ac-8587-4306-aa5b-52e6d9f2d227"></div>
            </form>
            <form method="POST" action="php/logout.php">
                <input type="submit" name="loguit" value="log uit">
            </form>
            HTML;
        }?>
    </div>
<?php
$template['footer'];
?>