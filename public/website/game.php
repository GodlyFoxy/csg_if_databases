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
                            <h4 class="ml-3 mr-2 ">Beoordeling:</h4>
                            <?php
                            if (getAverageRating($gameID) == 0) {
                                echo <<<HTML
                                <h4><i>Geen beoordeling!</i></h4>
                                HTML;
                            }
                            else {
                                echo <<<HTML
                                <select id="avgRating" name="avgRating">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <h4 class="ml-2"><?php echo getAverageRating($gameID); ?></h4>    
                                HTML;
                            }
                            ?>
                            <script type="text/javascript"> 
                                $(function() {
                                    $('#avgRating').barrating('show', {
                                        theme: 'fontawesome-stars-o',
                                        initialRating: <?php echo getAverageRating($gameID); ?>,
                                        readonly: true,
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <img class="figure-img img-fluid rounded" id="vierkant" src="images/<?php echo $gameID;?>.jpg">
                    <p class="ml-3"><?php echo $game['description'];?></p>
                </div>
                <div style="position:relative">
                
                    <?php
                    if(!isset($_SESSION['user'])) {
                        echo <<<HTML
                        <button class="btn btn-primary centerblurloginbutton" id="loginbutton" data-toggle="modal" data-target="#login" type="button">Login om een review achter te laten...</button>
                        <form class="unselectable blur">
                        HTML;
                    }
                    else {
                        echo <<<HTML
                        <form method="POST" action="php/send_review.php?gameID={$gameID}">
                        HTML;

                    }
                    ?>
                        <div class="d-flex border rounded">
                            <textarea class="col-7 ml-3 my-1" name="comment" rows="5" maxlength="400" placeholder="Type een review..."></textarea>
                            <div class="col">
                                <div class="row">
                                    <label class="mr-1 ml-3" for="rating">Beoordeling: </label>
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
                                </div>
                                <div class="h-captcha" data-sitekey="254a11ac-8587-4306-aa5b-52e6d9f2d227"></div>
                                <input name="review" type="submit" value="Verstuur review">
                            </div>
                        </div>
                    </form>
                </div>
                <?php echo getRatings(false,$gameID,false,true);?> 
                
            </div>
            <?php include($template['sideMenu']); ?>
        </div>      
    </div>
<?php $template['footer'] ?>