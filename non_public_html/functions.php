<?php

function verify_server() {
	/* Is the server local or remote? */
	if (HTTP_HOST === DOMAIN . '.' . LOCAL_TLD) {
	    // Server is local so set display errors to ON and set domain
	    define("HOST", 'local');
	    define("SERVER", PROTOCOL . DOMAIN . '.' . LOCAL_TLD);

		// define the db as local
		define("DB_HOST", DB_HOST_LOCAL);
		define("DB_USER", DB_USER_LOCAL);
		define("DB_PASS", DB_PASS_LOCAL);
		define("DB_NAME", DB_NAME_LOCAL);

		// Turn the display errors on
	    ini_set('display_errors', 'On');
	} elseif (HTTP_HOST === 'jewd.co') {
	    // Server is remote so set display errors to OFF and set domain
	    define("HOST", 'remote');
	    define("SERVER", PROTOCOL . DOMAIN . '.' . REMOTE_TLD);

		// define the db as local
		define("DB_HOST", DB_HOST_REMOTE);
		define("DB_USER", DB_USER_REMOTE);
		define("DB_PASS", DB_PASS_REMOTE);
		define("DB_NAME", DB_NAME_REMOTE);

		// Turn the display errors off
	    ini_set('display_errors', 'Off');
	} else {
		// The HTTP_HOST that was sanitized in prelims.php is not here
		trigger_error("This website is not meant for this domain", 	
		              E_USER_ERROR);
	}
}

function start_session() {	
	// Make sure session has not already been started
	if (!session_id()) {
		/* Set session handler and start session */
		//session_set_save_handler('_open', '_close', '_read', '_write', '_destroy', '_clean');
		session_start();
	}
}

function error_handler_php($number, $message, $file, $line, $vars) {
    //require_once('../../../non_public_html/projects/Spirit/includes/class.email.inc');

	// Start a new email message
    $email = new email;

	// Set the email body
    $email->body = ";
        <p>An error ($number) occurred on line
        <strong>$line</strong> and in the <strong>file: $file.</strong>
        <p> $message </p>
        <pre>" . print_r($vars, 1) . "</pre>";

	// Set the subject
    $email->subject = SERVER . " Error (PHP)";

	// If we ARE NOT debugging and are on the remote server then send the email
	if (DEBUG === FALSE && HOST === 'remote') {
        $email->send();
        if (isset($number) && is_numeric($number)) {
            if (($number !== E_NOTICE) && ($number < 2048)) {
        	    die("There was an error. Please try again later.");
    		}
        }
    } else {
		// We are either debugging or on the local server so show the error
        echo $email->body;
        exit;
    }
}

function html($value) {
	// Function to ensure that any info passed to the client is safe
	// First trim it
	$html = trim($value);

	// Then make sure it's valid
    $html = filter_var($html,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);

	// return it
    return($html);
}

function header_debug() {
	// A function to show all the variables should we need it
	echo '<pre>';
	$vars = get_defined_vars();
	print_r($vars);
	echo '</pre>';
	exit;
}

function is_short_valid($short) {
	// Is the short URL passed valid?
	if (filter_var($short, 
	               FILTER_VALIDATE_REGEXP, 
				   array('options'=>array(
					   'regexp'=>"/[a-zA-Z0-9]{4}/")
						)
					)
				)
	{
		// The short is valid
		return(true);
	} else {
		// The short isn't valid
		return(false);
	}
}

function is_long_valid($long) {
	// Is the long url valid
	if (filter_var($long, 
	               FILTER_VALIDATE_URL, 
				   FILTER_FLAG_HOST_REQUIRED)) {
		// The URL is valid
		return(true);

		// To Do: Check to make sure the URL actually exists
	} else {
		// The URL isn't valid
		return(false);
	}
}

function get_long_url_and_go($short, $DBH) {
	// $short has come from the same server so it is as safe as it was before
	// This means we can transmit it straight to the mysql server

	// Log the call
	bbclone_log($short . ' has been clicked');

	// See if the $short is in the db
	$sth = $DBH->prepare("SELECT `long`, `count` 
	                      FROM `links` 
						  WHERE `short` 
						  LIKE :short 
						  LIMIT 1");
	
	// Bind the short param passed
	$sth->bindParam(':short', $short, PDO::PARAM_STR, 4);

	// And execute the statement
	$sth->execute();

	// Is there a result?
	if ($result = $sth->fetch(PDO::FETCH_NUM)) {
		// There is a result so validate the returned url as 
		// it has come from a different server
		if (is_long_valid($result[0])) {
			// Returned URL is valid so increment the count by 1
			$long =  $result[0];
			$count = ++$result[1];

			// Update the db
			$sth = $DBH->prepare("UPDATE `links` 
			                      SET `count`=:count 
								  WHERE `long` 
								  LIKE :long 
								  LIMIT 1");

			// Bind the required params
			$sth->bindParam(':count', $count, PDO::PARAM_INT);
			$sth->bindParam(':long', $long, PDO::PARAM_STR);

			// Was the update successful?
			if ($sth->execute()) {
				// The update was successful
				header("Location: " . $long);
				exit;
			}
		} else {
			// Error: URL is not valid
			// TO DO: Send feedback
		}
	} else {
		// Error: The short is not in the db
		// TO DO: Send feedback
	}
}

function bbclone_log($msg) {
	// Getting an error so just return and will see to it shortly
	return;

	// Check to see if an error has been passed
	if ($msg === 'error') {
		// Grab the error message
		$msg = $_SESSION['error_msg'];
	}

	// log the event
	define("_BBC_PAGE_NAME", 'About');
	define("_BBCLONE_DIR", '../public_html/includes/bbclone/');
	define("COUNTER", _BBCLONE_DIR.'mark_page.php');
	if(is_readable(COUNTER))include_once (COUNTER);
}

?>
