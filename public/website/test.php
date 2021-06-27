<?php
include_once('php/preload.php');
include('php/getAverageRating.php');
include('php/getRatings.php');
error_reporting(E_ALL & ~E_NOTICE);
session_start();

$pageTitle = "Startpagina";

if(isset($_POST['signup'])) {
    header("Location: signup.php");
}

if (isset($_SESSION["user"])) {
    echo "<h1 style='color: green;'>Welkom ".$_SESSION["user"]."</h1>";
}

?>
    <head>
        <title>Website - <?php echo $pageTitle; ?></title>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha256-T/zFmO5s/0aSwc6ics2KLxlfbewyRz6UNw1s3Ppf5gE=" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-bar-rating@1.2.2/dist/themes/fontawesome-stars-o.css" integrity="sha256-0dPt1yDeWEWFqxjHMToED3U4O4KtYU4hqYLm3OWRtkA=" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <!--<link rel="stylesheet" type="text/css" href="styles/design.css">-->
        <link rel="stylesheet" type="text/css" href="styles/bloemen.css">

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        
        <!-- "Tijd" geleden-->
        <script src="https://cdn.jsdelivr.net/npm/timeago@1.6.7/jquery.timeago.js" integrity="sha256-DBRDTFjVy/EhxXd0RTlRd7B9kNqwmiicdtEh9HOgx1s=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/timeago@1.6.7/locales/jquery.timeago.nl.js" integrity="sha256-FrqQHAfQxMc6iFAwcVVvFqEGUeeLZ6uan1ODWYVfRjo=" crossorigin="anonymous"></script>
        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
        
        <!-- Starrating bar -->
        <script src="https://cdn.jsdelivr.net/npm/jquery-bar-rating@1.2.2/dist/jquery.barrating.min.js" integrity="sha256-4G5fW5q6We2bsDSgLCwkfKMFvGx/SbRsZkiNZbhXCvM=" crossorigin="anonymous"></script>       
        
        <!-- hcaptcha -->
        <script src="https://hcaptcha.com/1/api.js" async defer></script>
    </head>
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
            $avgRating = getAverageRating(6);
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
include $template['footer'];
?>