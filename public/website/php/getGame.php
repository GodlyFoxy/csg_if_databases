<?php
function getGame($id) {
require('database.php');

    $stmt = $conn->prepare("SELECT * FROM games WHERE gameID=(?) LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $records=$stmt->get_result();
    $stmt->close();
    $row = $records->fetch_assoc();

    return $row;
}
// END OF FILE