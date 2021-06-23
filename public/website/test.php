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
        <div id="menu">
            <h3>Gamerecensies</h3>
        </div>
        <div id="hoofdpagina">
            <div id="welkom">
            <h2>Welkom op onze hoofdpagina</h2>
                <img id="jumbo" src="images/vaderbloem.jpg">
                <div class="blokitem">
                    <h1>Laatst geplaatst</h1>
                    <img class="vierkant" src="images/gtav.jpg">
                    <p>
                    "Avontuurlijk en voor multiplayer" GTA V is wanneer het werkt een leuk spel, maar de
                    laadschermen duren te lang. Om eindelijk te kunnen racen ben je een half uur verder
                    Dit blok heeft naast de tekst nog een afbeelding. Hoe dit is gedaan kun je
                    zien in de CSS.
                    </p>
                    <p>Tweede alinea </p> /* Hier begint een tweede alinea. Let op de plaatsing van het
                    img-element voor de paragraaf. Dat is belangrijk voor de float. /*
                </div>
                <div class="blokitem">
                    <h1>Hier volgt een tweede item</h1>
                    <img class="vierkant" src="images/minecraft.jpg">
                    <p>
                    Dit spel heeft een grote come back gemaakt in de afgelopen jaren en het is logisch! 
                    Minecraft heeft veel verschillende kanten: pvp, hardcore survival en multiplayer games. 
                    Door toevoeging van shaders en texturepacks krijgt het ook een speciale look.
                    Dit blok heeft naast de tekst nog een afbeelding. Hoe dit is gedaan kun je
                    zien in de CSS.
                    </p>
                </div>     
                <div class ="blokitem">
                    <h1>Hier volgt een derde item</h1>
                    <img class="vierkant" scr="images/minecraft.jpg"> 
                    <p>
                    Andere game
                    </p>
                </div>                       
            </div>
            <div id="reclame">
                <h2>Bekijk ook eens...</h2>
                <img class="klein" src="images/tulpen.jpg">
                <img class="klein" src="images/hek.jpg">
                <img class="klein" src="images/gtav.jpg">
                <img class="klein" src="images/minecraft.jpg">                
            </div>
        </div>      
    </div>
<?php $template['footer'] ?>