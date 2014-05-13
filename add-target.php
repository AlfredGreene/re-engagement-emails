<?php

// Instateate database
$mysqli = require('./database.php');

// Read email address
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

// Add target to table
$stmt = $mysqli->prepare('insert into `targets` (id, added, ip, email) values (0, ?, ?, ?)');
$stmt->bind_param('iss', $_SERVER['REQUEST_TIME'], $_SERVER['REMOTE_ADDR'], $email);
if ( ! $stmt->execute()) {
	// Maybe perform some logging, but we don't want to alert the user about any errors
}
$stmt->close();
