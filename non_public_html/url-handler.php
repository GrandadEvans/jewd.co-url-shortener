<?php
/* OK so I want to
	- Bring in the URL - pre-defined as LONG
	- make sure it's safe
	- see if it's already in the db
		- if not:
			create new string for URL
			- grab the other bits of info needed
				- user IP
				- user?
				- created
			- add it to the db
			- redirect
		- if it is in the db:
			- grab the user IP, possible user info and created
			- get the short URL from the db
			- update the db info
			- redirect
*/

// Ok, let's start with a few vars etc
// Assume that all the $_POST super global is tainted
$dirty  = $_POST;
$errors = array();
$clean  = array();
$short  = '';
$long   = '';

// Is the url being sent via the api
if (isset($_GET['long']))
{
	// This is an api call
	// So override the $dirty = $_POST to reflect the $_GET var
	// Also urlencode the url
	$dirty['input_long'] = urldecode($_GET['long']);
}

// Right, is the URL a URL?
// Make sure we account for both with & without http://
if (is_long_valid($dirty['input_long']) || 
    is_long_valid('http://' . $dirty['input_long'])) {
	
	// We have test the URL & it's clean
	$clean['long'] = $dirty['input_long'];

	// Is the clean URL in the db already?
	
	// Search for the long URL in the db
	$sth = $DBH->prepare("SELECT `short`
	                      FROM `links` 
						  WHERE `long` 
						  LIKE :long 
						  LIMIT 1");
	
	// Bind the params
	$sth->bindParam(':long', $clean['long'], PDO::PARAM_STR);

	// Execute the statement
	$sth->execute();

	// Is there a result?
	if ($result = $sth->fetch(PDO::FETCH_NUM)) {

		// There is a result so validate the returned shortened url

		// The returned value should be as a str
		if (is_short_valid($result[0])) {

			// It is valid
			$clean['short'] = $result[0];

			// Send the user to their chosen detsination
			send_packing($clean['short']);
		}
		else // The results of the db are not what is expected
		{
			// I have assigned a random number to errors
			$_SESSION['error_msg'] = 'The database reults are not as expected [error 2894]';
			send_packing();
		}
	}
	else // There is no result so add the long url to the db
	{
		do {
			// 1st create a new str for the short
			$clean['short'] = create_id();
		} while (does_short_exist($clean['short']) === true);
			// As long as the id exists run the loop until a unique is is found

		// id is now created
		// now enter the details into the db
		$sth = $DBH->prepare("INSERT INTO `links` 
		                      SET `short`=:short, `long`=:long, `created`=NOW()");

		// assigned the params
		$sth->bindParam(':short', $clean['short'], PDO::PARAM_STR, CHARACTERS);
		$sth->bindParam(':long',  $clean['long'],  PDO::PARAM_STR);

		// make sure the query executes ok
		if ($sth->execute() === true) {

			// Send the user on his/heer way :)
			send_packing($clean['short']);
		}
		else // The query hasn't executed ok
		{
			$_SESSION['error_msg'] = 'There was an error adding your URL to the database [error 8624]';
			send_packing();
		}
	}
}
else // The passed variable is not a valid URL
{
	$_SESSION['error_msg'] = 'An invalid URL has been passed [error 8216]';
	send_packing();
}

function create_id() {
	// create a 13 char str
	$uniqid = uniqid();

	// Shorten it to the required length (get the last n chars
	$id = substr($uniqid, -CHARACTERS);
	return($id);
}

function does_short_exist($short) {
	// include the db file again?
	// Is there another way to do this?
	// I don't think this is the sort of thing that constants should be used for
	// & I don't want to use globals
	include('class.db.inc');

	// Search for the short URL in the db
	$sth = $DBH->prepare("SELECT `short` 
	                      FROM `links` 
						  WHERE `short` 
						  LIKE :short 
						  LIMIT 1");

	// Assign the params
	$sth->bindParam(':short', $url, PDO::PARAM_STR);

	// & execute
	$sth->execute();

	// was there a result?
	if ($sth->fetch(PDO::FETCH_NUM)) {
		// There was a result to return true
		return(true);
	} else {
		// There was no match so return false
		// Remember the question id does the short url exist
		return(false);
	}
}

function send_packing($short = false) {
	// If there has been an error then set the correct session var and go away
	if (isset($_SESSION['error_msg'])) {
		return;
	} else {
		// Set the server variable to the short URL
		$_SESSION['short_url'] = $short;

		// There is no need to exit as this is a require 
		// or an include so the caller script will carry on
	}
}

?>
