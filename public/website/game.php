<?php
include_once('php/preload.php');
include('php/getGame.php');
include('php/getRatings.php');
include('php/getAverageRating.php');
error_reporting(E_ALL & ~E_NOTICE);
session_start();

$gameID = htmlspecialchars($_GET["id"]);
$game = getGame($gameID);

$pageTitle = $game['title'];

if(!is_numeric($gameID) || ($gameID < 1 || $gameID > 4)) {
    header("Location: index.php");
}
include $template['header'];
?>
  <body>
    <div id="container">
        <div class="d-flex align-items-center" id="menu">
            <h3>Gamerecensies</h3>
            <?php
                if(!isset($_SESSION['user'])) { 
                    echo <<<HTML
                    <button class="btn btn-primary" id="loginbutton" data-toggle="modal" data-target="#login" type="button">
                        Login
                    </button>
                    HTML;
                }
            ?>
        </div>
        <?php include('php/alert.php');?>
        <div id="hoofdpagina">
            <div id="welkom">
                <h2 class='display-4'><?php echo $game['title'];?></h2>
                <div class="row justify-content-between">
                    <div class="col">
                        <h4>Publisher: <?php echo $game['publisher'];?></h4>
                        <h4>Release-date: <?php echo date("d/m/Y",strtotime($game['releaseDate']));?></h4>
                    </div>
                    <div class="col">
                        <h4>Developer: <?php echo $game['developer'];?></h4>
                        <div class="row align-items-center ">
                            <h4 class="mr-2"> Beoordeling:</h4>
                            <select id="avgRating" name="avgRating">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <script type="text/javascript"> 
                                $(function() {
                                    $('#avgRating').barrating('show', {
                                        theme: 'fontawesome-stars-o',
                                        initialRating: <?php echo getAverageRating($gameID); ?>,
                                        readonly: true

                                    });
                                });
                            </script>
                            <h4 class="ml-2"><?php echo getAverageRating($gameID); ?></h4>    
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <img class="figure-img img-fluid rounded" id="vierkant" src="images/<?php echo $gameID;?>.jpg">
                    <p class="ml-3"><?php echo $game['description'];?></p>
                </div>
                <form method="POST" action="php/send_review.php">
                    <div class="d-flex">
                        <textarea class="col-7" name="comment" rows="5" maxlength="255" placeholder="Type een review..."></textarea>
                        <div class="col">
                            <label for="rating">Beoordeling: </label>
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
                                        theme: 'fontawesome-stars-o'
                                    });
                                });
                            </script>
                            <input name="review" type="submit" value="Verstuur review"><br><br>
                            <div class="h-captcha" data-sitekey="254a11ac-8587-4306-aa5b-52e6d9f2d227"></div>
                        </div>
                    </div>
                </form>
                <?php echo getRatings(false,$gameID,false);?>                
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