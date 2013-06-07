<?php
/* File Itinerary
 *    configure the database
 *    define the personal variables
 *    define debug status
 *    define the domain bits
 *    define a set of ini_sets
*/

/*------------------------------*/
/*   Configure the db details   */
/*------------------------------*/
define("DB_HOST", "");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");

// define personal details for things such as the error email script
define("PERS_NAME", "");
define("PERS_EMAIL", "");

// Standard debug status
define("DEBUG", TRUE);

/*----------------------------------*/
/*   Configure the domain details   */
/*----------------------------------*/

// I suppose it could be https:// ?
define("PROTOCOL", "http://");

// Is there a local TLD?
define("LOCAL_TLD", "lo");

// The remote TLD
define("REMOTE_TLD", "co");

// Finally the domain name itself
define("DOMAIN", "jewd");

// Set the amount of characters to be used as "short"
define("CHARACTERS", 4);

/*----------------------------*/
/*   Configure the ini_sets   */
/*----------------------------*/

// Set the error reporting level. I have it set to high
ini_set("error_reporting", E_ALL | E_STRICT);

// Turn off the naughty magic_quotes
ini_set("magic_quotes_gpc", "Off");

// Change the timezone to suite
ini_set("date.timezone","Europe/London");

// Make sure we log the errors
ini_set("log_errors", "On");

// Set the error log location
ini_set("error_log", "logs/errors.log");

// We do not need the fopen so turn it off
ini_set("allow_url_fopen", "Off");

// Compress the pages if possible
ini_set("zlib.output_compression", "On");

?>
