<?php

// Instantiate targets library
require('./targets.library.php');
$targets = new Joelvardy\Targets();

// Read targets
$targets = $targets->read();

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

	$targets->delete($target->email); // Add some logging for errors (if the user isn't removed from the table they will keep recieving emails)

}
