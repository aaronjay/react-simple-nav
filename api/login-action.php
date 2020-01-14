<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include $_SERVER['DOCUMENT_ROOT'] . '/init.php';

if ($_SERVER['REQUEST_METHOD']==='POST' && empty($_POST)) {
 	$_POST = json_decode(file_get_contents('php://input'), true);
}

$Email = (array_key_exists("Email", $_POST) ? $_POST['Email'] : "");
$Pass = (array_key_exists("Pass", $_POST) ? $_POST['Pass'] : "");

$ErrorMsg = "";

if ($Email == '' || $Pass == '') {
	$ErrorMsg = "Email and Password are required";
} else {
	if ($Pass != $demo_password) {
		$ErrorMsg = "Invalid Password... hint, it is: " . $demo_password;
	}
}

if ($ErrorMsg == "") {
	if (safeCookie("LoginKey") != "AaronJayLev") {
		setcookie("LoginKey", "AaronJayLev", time() + $session_length, '/'); // Expire in 1 day
	}
}


header('Content-Type: application/json');
echo json_encode(array(
	"LoggedIn" => ($ErrorMsg == "" ? 1 : 0), 
	"ErrorMsg" => $ErrorMsg
));

?>

