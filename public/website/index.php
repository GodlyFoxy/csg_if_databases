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
    //echo "<h1 style='color: green;'>Welkom ".$_SESSION["user"]."</h1>";
}


include $template['header'];
?>
  <body>
    <div id="container">
        <div id="hoofdpagina">
            <div id="welkom">
                <h2>Welkom op onze hoofdpagina</h2>
                    <img id="jumbo" src="images/vaderbloem.jpg">
                    <h1 class='text-center'>Nieuwste recensies</h1>
                    <?php echo getRatings(3, false, true, false);?>
            </div>
            <?php include($template['sideMenu']); ?>
        </div>      
    </div>
<?php $template['footer'] ?>