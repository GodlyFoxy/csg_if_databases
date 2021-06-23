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

include $template['header']
?>
<body>
    <div id="container">
    <?php include('php/alert.php');?>
        <?php 
        if(!isset($_SESSION['user'])) { 
            echo <<<HTML
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login">
                Login
            </button>
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
                var averageRating = $avgRating
                    $(function() {
                        $('#rating').barrating('show', {
                            theme: 'fontawesome-stars-o',
                            initialRating: averageRating
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