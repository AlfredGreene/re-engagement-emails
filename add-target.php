<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Instantiate targets library
require('./targets.library.php');
$targets = new Joelvardy\Targets();

// Read email address
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$targets->create($email); // Add some logging for errors
