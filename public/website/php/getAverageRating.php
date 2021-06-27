<?php

function getAverageRating($gameid) 
{
    require('database.php');

    $stmt = $conn->prepare("SELECT ROUND(AVG(rating),1) as avgRating FROM reviews WHERE gameID=(?)");
    $stmt->bind_param('i', $gameid);
    $stmt->execute();

    $records=$stmt->get_result();
    $stmt->close();
    $row = $records->fetch_assoc();

    if (isset($row['avgRating'])) {
        $avg = $row['avgRating'];
    }
    else {
        $avg = 0;
    }
    return $avg;
}