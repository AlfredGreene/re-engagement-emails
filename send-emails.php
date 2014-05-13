<?php

// Instateate database
$mysqli = require('./database.php');

// Select targets from table
$targets = array();
$before = ($_SERVER['REQUEST_TIME'] - (60 * 60));
$stmt = $mysqli->prepare('select id, added, ip, email from `targets` where added < ?');
$stmt->bind_param('i', $before);
$stmt->execute();
$stmt->bind_result($id, $added, $ip, $email);
while($stmt->fetch()) {
	$targets[$id] = (object) array(
		'added' => $added,
		'ip' => $ip,
		'email' => $email
	);
}
$stmt->close();

// Iterate through targets
foreach ($targets as $target_id => $target) {

	$from = 'STORE <public.address@store.tld>';
	$subject = 'Discount for STORE';

	$headers = "From: {$from}\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	ob_start();
	require('./email.html');
	$message = ob_get_clean();

	if ( ! mail($target->email, $subject, $message, $headers)) {
		// Log errors, you want to make sure the emails are actually sent!
	}

	// TODO: Have this code in a library so you can use it here and in the remove-target.php action
	$stmt = $mysqli->prepare('delete from `targets` where email = ?');
	$stmt->bind_param('s', $target->email);
	$stmt->execute(); // You probably want to log errors here because otherwise the user will keep being sent re-engagement emails
	$stmt->close();

}
