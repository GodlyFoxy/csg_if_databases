<?php
include_once('php/preload.php');
include('php/averageRating.php');
include('php/getRecentRating.php');
error_reporting(E_ALL & ~E_NOTICE);
session_start();

$pageTitle = "Startpagina";

if(isset($_POST['signup'])) {
    header("Location: signup.php");
}

if (isset($_SESSION["user"])) {
    //echo "<h1 style='color: green;'>Welkom ".$_SESSION["user"]."</h1>";
}


include $template['header'];
?>
  <body>
    <div id="container">
        <div id="menu" class="d-flex align-items-center">
            <h3>Gamerecensies</h3>
            <?php
                if(!isset($_SESSION['user'])) { 
                    echo <<<HTML
                    <button type="button" id="loginbutton" class="btn btn-primary" data-toggle="modal" data-target="#login">
                        Login
                    </button>'
                    HTML;
                }
            ?>
        </div>
        <div id="hoofdpagina">
        <?php include('php/alert.php');?>
            <div id="welkom">
                <h2>Welkom op onze hoofdpagina</h2>
                    <img id="jumbo" src="images/vaderbloem.jpg">
                    <?php echo getRecentRating();?>
            </div>
            <div id="reclame">
                <h2>Kies een game</h2>
                <a href="">
                <img class="klein" src="images/tulpen.jpg">
                </a>
                <a href="">
                <img class="klein" src="images/hek.jpg">
                </a>
                <a href="">
                <img class="klein" src="images/1.jpg">
                </a>
                <a href="">
                <img class="klein" src="images/2.jpg">     
                </a>           
            </div>
            <div class="modal fade" id="login">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Login</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>      
    </div>
<?php $template['footer'] ?>