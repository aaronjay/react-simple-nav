<?php

$script_url = $_SERVER['REDIRECT_URL']; // might be SCRIPT_URL

if (substr($script_url, 0, 1) == '/') {
	$script_url = substr($script_url, 1); // strip off leading /
}

if ($script_url != '' && substr($script_url, -1, 1) == '/') {
	$script_url = substr($script_url, 0, strlen($script_url) - 1);
}

if (file_exists($script_url . ".php")) {
    include $script_url . ".php";
    exit;
}

include "home.php";

?>


