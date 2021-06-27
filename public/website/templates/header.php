<!doctype html>
<html lang="nl">
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
    <header>
        <div class="d-flex align-items-center" id="menu">
            <a href="index.php" class="text-decoration-none">
                <h3>Gamerecensies</h3>
            </a>
            <?php
                if(!isset($_SESSION['user'])) { 
                    echo <<<HTML
                    <button class="btn btn-primary" id="loginbutton" data-toggle="modal" data-target="#login" type="button">Login</button>
                    HTML;
                }
                else {
                    echo <<<HTML
                    <a class="btn btn-primary" type="button" id="logoutbutton" href="php/logout.php" >
                        Log uit
                    </a>
                    HTML;
                }
            ?>
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
                            <div class="form-group">
                                <label for="username">E-mail/Gebruikersnaam</label>
                                <input class="form-control" type="text" name="username" id="username" placeholder="Voer uw gebruikersnaam of e-mail in..." autocomplete="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Wachtwoord</label>
                                <input class="form-control" name="password" id="password" type="password"placeholder="Geef uw wachtwoord..." autocomplete="current-password" required>
                            </div>
                            <!-- hcaptcha -->
                            <div class="h-captcha mt-2" data-sitekey="254a11ac-8587-4306-aa5b-52e6d9f2d227"></div>
                            <button name="submit" type="submit">Login</button>
                            <button name="register" data-toggle="modal" data-target="#register" data-dismiss="modal" type="button">Nog geen account? Maak er gratis een aan!</button>
                        </form>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="register">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Registratie</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" method="POST" action="php/register.php" novalidate>
                            <div class="form-group">
                                <label for="username">Gebruikersnaam</label>
                                <!-- Gebruikersnaam begint met letter of cijfer mag streep of punt bevatten maar niet meerdere achter elkaar tussen 5 en 20 characters-->
                                <input class="form-control" type="text" name="username" id="newUsername" placeholder="Voer uw gebruikersnaam in..." autocomplete="username" pattern="^[a-zA-Z0-9]([._-]|[a-zA-Z0-9]){4,19}$" required>
                                <small id="usernameHelpBlock" class="form-text text-muted">
                                    Je gebruikersnaam moet tussen de 5 en 20 tekens lang zijn en mag alleen met een letter of cijfer beginnen en daarnaast alleen punten, strepen, letters en cijfers bevatten. 
                                </small>
                                <div class="invalid-feedback">
                                     Kies een gebruikersnaam.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input class="form-control" type="email" name="email" id="newEmail" placeholder="Voer uw e-mail in..." autocomplete="username" required>
                                <div class="invalid-feedback">
                                     Voer een geldig e-mail adres in.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Wachtwoord</label>
                                <!-- password minimaal 1 letter en 1 cijfer 8 characters lang-->
                                <input class="form-control" name="password" id="newPassword" type="password" placeholder="Geef uw wachtwoord..." autocomplete="new-password" pattern="^(?=.*[A-Za-z])(?=.*\d).*[A-Za-z\d*.!@$%^&(){}[\]:;<>,.?\/~_+-=|\\]{8,}$" aria-describedby="passwordHelpBlock" required>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Je wachtwoord moet minimaal 8 tekens lang zijn en tenminste 1 letter en 1 cijfer bevatten.
                                </small>                                
                                <div class="invalid-feedback">
                                     Kies een wachtwoord van tenminste 8 tekens met tenminste 1 letter en 1 cijfer.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="repeatPassword">Herhaal wachtwoord</label>
                                <input class="form-control" name="repeatPassword" id="repeatPassword" type="password" placeholder="Herhaal Wachtwoord..." autocomplete="new-password" pattern="^(?=.*[A-Za-z])(?=.*\d).*[A-Za-z\d*.!@$%^&(){}[\]:;<>,.?\/~_+-=|\\]{8,}$" required>
                                <div class="invalid-feedback" id="repeatPasswordText">
                                     Herhaal wachtwoord.
                                </div>
                                <div class="text-danger" id="passwordNoMatchText" hidden>
                                     Wachtwoord komt niet overeen.
                                </div>
                            </div>
                            <!-- hcaptcha -->
                            <div class="h-captcha mt-2" data-sitekey="254a11ac-8587-4306-aa5b-52e6d9f2d227"></div>
                            <button type="submit" id="submitBtn" name="submit">Registreer</button>
                        </form>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {

                        if (form.checkValidity() === false || !validatePassword()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                    });
                }, false);
            })();

            function validatePassword(){
                if($("#newPassword").val()!=$("#repeatPassword").val()) {
                    document.getElementById("repeatPassword").setCustomValidity("Passwords Don't Match");
                    document.getElementById("repeatPasswordText").innerHTML("Wachtwoord komt niet overeen.");
                    return false;
                } else {
                    document.getElementById("repeatPassword").setCustomValidity("");
                    return true;
                }
            }
            //als een van deze 2 verandert voor functie uit
            document.getElementById("newPassword").onkeyup = validatePassword;
            document.getElementById("repeatPassword").onkeyup = validatePassword;
        </script>
        
        <?php include('php/alert.php');?>  
    </header>