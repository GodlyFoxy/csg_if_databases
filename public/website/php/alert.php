<?php

if (isset($_SESSION["alert"])) {
    switch ($_SESSION["alert"]) {
    // Review
    case 'R0':
        echo <<< HTML
        <div class="alert alert-success">
            <strong>Succes!</strong> Review verzonden</a>.
        </div>
        HTML;
        break;
    // Loguit
    case 'L0':
        echo <<< HTML
        <div class="alert alert-success">
            <strong>Succes!</strong> Uitgelogd</a>.
        </div>
        HTML;
        break;
    // Algemeen
    case 1:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> Je account is gedeactiveerd</a>.
        </div>
        HTML;
        break;
    case 2:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> Doe de captcha opnieuw</a>.
        </div>
        HTML;
        break;
    // Login
    case 3:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> Het wachtwoord is onjuist</a>.
        </div>
        HTML;
        break;
    case 4:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> Gebruikersnaam of Email onjuist</a>.
        </div>
        HTML;
        break;
    // Registratie
    case 5:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> Gebruikersnaam is verplicht</a>.
        </div>
        HTML;
        break;
    case 6:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> Gebruikersnaam voldoet niet aan de voorwaarden</a>.
        </div>
        HTML;
        break;
    case 7:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> Wachtwoord is verplicht</a>.
        </div>
        HTML;
        break;
    case 8:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> Wachtwoord voldoet niet aan de voorwaarden</a>.
        </div>
        HTML;
        break;
    case 9:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> E-mail is verplicht</a>.
        </div>
        HTML;
        break;
    case 10:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> Gebruikersnaam is in gebruik</a>.
        </div>
        HTML;
        break;
    case 11:
        echo <<< HTML
        <div class="alert alert-danger">
            <strong>Fout!</strong> E-mail is in gebruik</a>.
        </div>
        HTML;
        break;
               
                                
    }
    unset($_SESSION['alert']);
}

?>
