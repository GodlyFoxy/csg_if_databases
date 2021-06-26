<?php

function getRatings($limit, $gameID, $images) {
    require('database.php');

    if(!$limit) {
        if(!$gameID){
            $stmt = $conn->prepare("SELECT * FROM reviews ORDER BY postedAt DESC");
        }
        else {
            $stmt = $conn->prepare("SELECT * FROM reviews WHERE gameID=(?) ORDER BY postedAt DESC");
            $stmt->bind_param('i', $gameID);
        }
    }
    else {
        if(!$gameID){
            $stmt = $conn->prepare("SELECT * FROM reviews ORDER BY postedAt DESC LIMIT ?");
            $stmt->bind_param('i', $limit);
        }
        else {
            $stmt = $conn->prepare("SELECT * FROM reviews WHERE gameID=(?) ORDER BY postedAt DESC LIMIT ?");
            $stmt->bind_param('ii', $limit, $gameID);
        }
    }
    $stmt->execute();
    $records=$stmt->get_result();
    $stmt->close();

    while($row = $records->fetch_assoc()) {
        $rows[] = $row;
    }

    foreach($rows as $review) {

        $stmt = $conn->prepare("SELECT username FROM users WHERE userID=? LIMIT 1");
        $stmt->bind_param('i', $review['userID']);
        $stmt->execute();
        $records=$stmt->get_result();
        $stmt->close();
        $row = $records->fetch_assoc();
        $username = $row['username'];

        $stmt = $conn->prepare("SELECT title FROM games WHERE gameID=? LIMIT 1");
        $stmt->bind_param('i', $review['gameID']);
        $stmt->execute();
        $records=$stmt->get_result();
        $stmt->close();
        $row = $records->fetch_assoc();
        $title = $row['title'];

        $datetime = new DateTime($review['postedAt']);
        $time = $datetime->format('c');

        echo <<<HTML
        <div class="blokitem border rounded d-flex my-1">
        HTML;
        //Laat game afbeelding zien
        if($images) {
            echo <<<HTML
                <div class="col p-1">
                    <a href="game.php?id={$review['gameID']}"> 
                        <img class="vierkant img-thumbnail align-middle" src="images/{$review['gameID']}.jpg">
                    </a>
                </div>
            HTML;
        }
        echo <<<HTML
            <div class="d-flex flex-column col-8">
                <h1 class="text-nowrap" style="font-size: 1.5em;" id='ago {$review['reviewID']}'>$time</h1>
                <script>document.getElementById('ago {$review['reviewID']}').textContent = jQuery.timeago("$time")+" geplaatst"</script>
                <div class="d-flex">
                    <p>
                        Gepost door: $username
                    </p>
                    <form class='mx-4'>
                        <select id="rating{$review['reviewID']}">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </form>
                <script type="text/javascript"> 
                    $(function() {
                        $('#rating{$review['reviewID']}').barrating('show', {
                            theme: 'fontawesome-stars-o',
                            initialRating: {$review['rating']},
                            readonly: true
                        });
                    });
                </script>
        HTML;
        //Laat gamenaam zien
        if(!$gameID){
        echo <<<HTML
                    <p class=''>
                        Game: <a href="game.php?id={$review['gameID']}">{$title}</a>
                    </p>
        HTML;
        }
        echo <<<HTML
                </div>
                <p class='text-left'>
                    {$review['comment']}
                </p>                
            </div>
        </div> 
        HTML;
    }
}