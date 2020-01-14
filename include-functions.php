<?php

function safeReadFile($file) {
	if (! file_exists($file)) {
		die($file . ' file does not exist');
	} else {
		$html = file_get_contents($file);
	}
	return $html;
}

function getNextTag($html) {

	$i = strpos($html, '{{');
	if ($i !== false) {
		$j = strpos($html, '}}', $i + 1);
		if ($j !== false) {
			$start = substr($html, 0, $i);
			$tag = substr($html, $i + 2, $j - $i - 2);
			$end = substr($html, $j + 2);
			return array($start, $tag, $end);
		}
	}
	return false;
}

function getTagString($st) {
	if (substr($st, 0, 1) == '"' && substr($st, -1) == '"') {
		return substr($st, 1, strlen($st) - 2);
	} else if (substr($st, 0, 1) == "'" && substr($st, -1) == "'") {
		return substr($st, 1, strlen($st) - 2);
	} else {
		return false;
	}
}

function randomPassword($passwordLength) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $result = "";
    $alphabetLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $passwordLength; $i++) {
        $n = rand(0, $alphabetLength);
        $result = $result . substr($alphabet, $n, 1);
    }
    return $result;
}

function apiCallJson($url, $data) {
	$postData = json_encode($data);
			
    try {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

		curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData))
        );
		$results = curl_exec($ch);

		$curlError = curl_error($ch);
		if ($curlError != "") {
			die("Curl Error: " . $curlError);
		}

		$json = json_decode($results);
		curl_close($ch);

        if ($json == null && json_last_error() !== JSON_ERROR_NONE) {
            die('JSON Error in apiCallJson: <span style="color: red">' . $results . '</span>');
		}

		return $json;		

	} catch (Exception $e) {
		echo 'Error setting up curl: ',  $e->getMessage(), "\n";
	}        
    return false;
}	

function apiInit($url, $httpHeaders = array())
{
	// Create Curl resource
	$ch = curl_init();

	// Set URL
	curl_setopt($ch, CURLOPT_URL, $url);

	//Return the transfer as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'LeadSages API');

	$headers = array();
	foreach ($httpHeaders as $key => $value) {
		$headers[] = "$key: $value";
	}
	//Set HTTP Headers
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	return $ch;

}

function apiRequest($ch)
{
	# Check for 429 leaky bucket error
	$httpCode = 0;

	$output = curl_exec($ch);
		
	$response = explode("\r\n\r\n", $output, 2);
	while ($response[0] == 'HTTP/1.1 100 Continue') {
		$response = explode("\r\n\r\n", $response[1], 2);
	}

	if (1 < count($response)) {
		$response = \array_slice($response, -2, 2);
		list($header, $body) = $response;

		$headers = array();
		foreach (explode("\r\n", $header) as $st) {
			$pair = explode(': ', $st, 2);
			if (isset($pair[1])) {
				$headers[$pair[0]] = $pair[1];
			}
		}
	} else {
		$header = "";
		$headers = array();
		$body = $response[0];
	}
	
	$lastHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$httpCode =	$lastHttpCode;			

	if (curl_errno($ch)) {
		die("Error number: " . curl_errno($ch) . " Error : " . curl_error($ch));
	}

	// close curl resource to free up system resources
	curl_close($ch);
	
	$json = false;
	if (array_key_exists("Content-Type", $headers) && $headers['Content-Type'] == "application/json") {
		$json = json_decode($body, true);
	}	
		
	return array("header" => $header, "headers" => $headers, "body" => $body, "json" => $json, "code" => $httpCode);
}

function apiPost($url, $data, $httpHeaders = array())
{
	if (array_key_exists("AccessToken", $_COOKIE)) 
	{
    	$httpHeaders['X-Leadsages-Access-Token'] = $_COOKIE['AccessToken'];
    }
	$ch = apiInit($url, $httpHeaders);
	
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	return apiRequest($ch);
}


function safePost($param, $default = "") {
	return isset($_POST) && array_key_exists($param, $_POST) ? $_POST[$param] : $default;
}

function safeGet($param, $default = "") {
	return isset($_GET) && array_key_exists($param, $_GET) ? $_GET[$param] : $default;
}

function safeCookie($param, $default = "") {
	return isset($_COOKIE) && array_key_exists($param, $_COOKIE) ? $_COOKIE[$param] : $default;
}

?>