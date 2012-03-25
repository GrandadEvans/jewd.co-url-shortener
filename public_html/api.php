<?php
require("../non_public_html/prelims.php");

// If the form has been submitted (no-js) then we want to action it

if ((isset($_GET['long']) && strlen($_GET['long']) > 1)) {

	// Send details to form processor
	require('../non_public_html/url-handler.php');

	// Is there an error message?
	if (isset($_SESSION['error_msg'])) {
		// There is a message so show the user the message
		echo 'Error: ' . $_SESSION['error_msg'];

		// Make sure we unset the error message
		unset($_SESSION['error_msg']);
	} else {
		// There is no error so echo the short url
		echo SERVER . '/' . $_SESSION['short_url'];

		// Unset the short url session variable
		unset($_SESSION['short_url']);
	}
	exit;
}
?>
