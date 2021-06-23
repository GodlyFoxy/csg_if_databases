<?php
$servernaam = "localhost";
$gebruikersnaam = "username";
$wachtwoord = "password";
$database = "review_website";

$conn = new mysqli($servernaam, $gebruikersnaam, $wachtwoord, $database);
// Controleer de verbinding
if ($conn->connect_error) {
// Geef de foutmelding die de server teruggeeft en stop met de uitvoer van PHP (die)
die("Verbinding mislukt: " . mysqli_connect_error());
}

//END OF FILE