<?php

// Instateate database
$mysqli = require('./database.php');

// Read email address
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

// Remove target from table
$stmt = $mysqli->prepare('delete from `targets` where email = ?');
$stmt->bind_param('s', $email);
if ( ! $stmt->execute()) {
	// Maybe perform some logging, but we don't want to alert the user about any errors
}
$stmt->close();
