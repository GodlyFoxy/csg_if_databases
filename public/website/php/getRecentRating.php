<?php

function getRecentRating() {
    require('database.php');

    $stmt = $conn->prepare("SELECT * FROM reviews ORDER BY createdAt DESC LIMIT 3");
    $stmt->execute();
    $records=$stmt->get_result();
    $stmt->close();
    $rows = array();

    while($row = $records->fetch_assoc()) {
        $rows[] = $row;
    }


    $output = <<< HTML
        <div class="blokitem">
            <h1>Nieuwste recensies</h1>
            <h1>1 uur geleden geplaatst</h1>
            <a href=""> 
                <img class="vierkant" src="images/{$rows[0]['gameID']}.jpg">
            </a>
            <p>
                <a href="">bla bla</a>
            </p>
            <p>
            {$rows[0]['comment']}
            </p>
        </div>
        <div class="blokitem">
            <h1>2 uur geleden geplaatst</h1>
            <a href=""> 
                <img class="vierkant" src="images/{$rows[1]['gameID']}.jpg">
            </a>
            <p>
                <a href="">bla bla</a>
            </p>
            <p>
            {$rows[1]['comment']}
            </p>
        </div>
        <div class="blokitem">
            <h1>3 uur geleden geplaatst</h1>
            <a href=""> 
                <img class="vierkant" src="images/{$rows[2]['gameID']}.jpg">
            </a>
            <p>
                <a href="">bla bla</a>
            </p>
            <p>
            {$rows[2]['comment']}
            </p>
        </div>
    HTML;

    return $output;
}