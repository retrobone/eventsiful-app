<?php
session_start();

$_SESSION = array();

session_destroy();

header("location: /event-registration-system/index.php");
exit;
?>