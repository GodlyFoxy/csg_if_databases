<?php
//LIMIT limiteert het max aantal reviews
//Images bool: wil je het gameplaatje ernaast
//Pages bool: Meerdere paginas in review section
function getRatings($limit, $gameID, $images, $pages) {
    require('database.php');
    $reviewNumber=0;

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

    if(!empty($rows)){
        $amountReviews = count($rows);

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
            $comment = htmlspecialchars($review['comment']);

            if($reviewNumber % 3 === 0 && $pages){
                if($reviewNumber !== 0)
                {
                echo <<<HTML
                </div>
                HTML;
                }
                echo <<<HTML
                <div class="tab">
                HTML;
            }

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
                    <script> 
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
                    <p class='text-left text-break'>
                        {$comment}
                    </p>                
                </div>
            </div> 
            HTML;
            $reviewNumber++;
            if($reviewNumber === $amountReviews && $pages) {
                echo <<<HTML
                </div>
                HTML;
            }
        }
        
        if ($pages) {
            echo <<<HTML
            <div class="d-flex row">
                <p class="text-center col" id="pageNumber">page</p>
                <div>
                    <div class="row h-75 mr-3">
                        <button class="mr-1" id="prevBtn" type="button" onclick="nextPrev(-1)">Previous</button>
                        <button class="ml-1" id="nextBtn" type="button" onclick="nextPrev(1)">Next</button>
                    </div>
                </div>
                <!-- Circles which indicates the steps of the form: -->
                <script>
                    // Overgenomen van https://www.w3schools.com/howto/howto_js_form_steps.asp?
                    var currentTab = 0;
                    var x = document.getElementsByClassName("tab");
                    // Display the current tab
                    showTab(currentTab);
                    function showTab(n) {
                    // This function will display the specified tab of the form ...
                    x[n].style.display = "block";
                        // ... and fix the Previous/Next buttons:
                        if (n == 0) {
                            document.getElementById("prevBtn").style.display = "none";
                        } else {
                            document.getElementById("prevBtn").style.display = "flex";
                        }
                        //
                        if (n+1 == x.length) {
                            document.getElementById("nextBtn").style.display = "none";
                        } else {
                            document.getElementById("nextBtn").style.display = "flex";
                        }
                        //Haal pagina counter weg als het niet nodig is
                        if(x.length <= 1) {
                            document.getElementById("pageNumber").style.display = "none";
                        }
                        // ... and run a function that displays the correct step indicator:
                        document.getElementById("pageNumber").innerHTML = (n+1)+"/"+x.length;
                    }
                    //Functie om naar volgende of vorige tab te gaan
                    function nextPrev(n) {
                        // This function will figure out which tab to display
                        // Hide the current tab:
                        x[currentTab].style.display = "none";
                        // Increase or decrease the current tab by 1:
                        currentTab = currentTab + n;
                        // Otherwise, display the correct tab:
                        showTab(currentTab);
                    }
                </script>      
            </div>
            HTML;
        }
    }
    else {
        echo <<<HTML
        <h2 class="mt-5">Geen reviews!</h2>
        HTML;
    }
}