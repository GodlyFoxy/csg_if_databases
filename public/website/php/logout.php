<?php
session_start();
session_unset();
session_destroy();

$_SESSION["notification"] = 'L0';

header("Location: ../index.php");
// END OF FILE