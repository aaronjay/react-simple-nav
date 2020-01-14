<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('date.timezone', 'UTC');
date_default_timezone_set('UTC');

require "config.php";
include "include-functions.php";

if ($_SERVER['REQUEST_METHOD']==='POST' && empty($_POST)) {
 	$_POST = json_decode(file_get_contents('php://input'), true);
}

?>