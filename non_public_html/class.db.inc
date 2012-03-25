<?php
try {
	// Try connecting to the db using the suppied params
	$DBH = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => TRUE));
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch(PDOException $e) {
	// Unable to connect to the db so send an email
	echo "Unable to connect to Database";
	require_once('class.email.inc');
	$email = new email;
	$email->body = ";
		<p>A Mysql error has occurred<br />
		Unable to Connect to Database<br />
		<strong>File: </strong> " . html($_SERVER['PHP_SELF']) . "</p>
		<p>" . html($e->getMessage()) . "</p>";
	$email->subject = "jewd Error (MySQL)";
    $email->send();
	file_put_contents('PDOErrors.log', html($e->getMessage()), FILE_APPEND);
}
?>

