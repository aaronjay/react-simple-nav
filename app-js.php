<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-type: application/javascript");

function topComments($st) {

echo <<< EOF


/**
 * 
 * $st
 * 
 */


EOF;
}

echo <<< EOF
const { Component, useCallback, useState, useEffect } = React;
const { render } = ReactDOM;

EOF;

topComments("Routes");
include "src/routes.js";

topComments("Utils");
include "src/utils.js";

topComments("Loading");
include "src/loading.js";

topComments("Main");
include "src/main.js";

topComments("Home");
include "src/home.js";

topComments("Login");
include "src/login.js";

topComments("One");
include "src/one.js";

?>