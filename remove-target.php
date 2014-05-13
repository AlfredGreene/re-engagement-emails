<?php

// Instantiate targets library
require('./targets.library.php');
$targets = new Joelvardy\Targets();

// Read email address
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$targets->delete($email); // Add some logging for errors
