<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include $_SERVER['DOCUMENT_ROOT'] . '/init.php';

$LoggedIn = safeCookie("LoginKey") == "AaronJayLev" ? 1 : 0;

header('Content-Type: application/json');
echo json_encode(array("LoggedIn" => $LoggedIn)); 

?>