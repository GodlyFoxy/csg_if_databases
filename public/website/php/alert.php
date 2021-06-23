<?php

if (isset($_SESSION["notification"])) {
    switch ($_SESSION["notification"]) {
    // Review
    case 'R0':
        echo' 
        <div class="alert alert-success">
            <strong>Succes!</strong> Review verzonden</a>.
        </div>
        ';
        break;
    // Loguit
    case 'L0':
        echo'
        <div class="alert alert-success">
            <strong>Succes!</strong> Uitgelogd</a>.
        </div>
        ';
        break;
    // Algemeen
    case 1:
        echo'
 
        <div class="alert alert-danger">
            <strong>Fout!</strong> Je account is gedeactiveerd</a>.
        </div>
        ';
        break;
    case 2:
        echo'
 
        <div class="alert alert-danger">
            <strong>Fout!</strong> Doe de captcha opnieuw</a>.
        </div>
        ';
        break;
    // Login
    case 3:
        echo'
 
        <div class="alert alert-danger">
            <strong>Fout!</strong> Het wachtwoord is onjuist</a>.
        </div>
        ';
        break;
    case 4:
        echo'
 
        <div class="alert alert-danger">
            <strong>Fout!</strong> Gebruikersnaam of Email onjuist</a>.
        </div>
        ';
        break;
    // Registratie
    case 5:
        echo "Doe de captcha opnieuw";
        break;
    }
    unset($_SESSION['notification']);
}

?>
