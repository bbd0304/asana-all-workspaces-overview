<?php
// ************************************ //
// Enter your Personal Acces Token 		//
// below and rename file to config.php 	//
// ************************************ //
$api_key = "0/3587e60b35fc8aa37b1c2056be2c1adc";


// Safety feature so people cannot access this page and steal your API key
if(!defined('SAFEASANA')){
	echo 'what are you doing here?';
	exit(1);
}


// For some strange reason the Asana API Workspace ID is not the same
// as the URL to a workspace, so to make URLs to workspaces work, 
// you must configure them here.

function idToURL($input){
	// Repeat if you have multiple workspaces...
	// Ehmm, probably you do. Why else are you using this code?
	// Example of 2 workspaces
	if($input == "12345") // workspace ID from API

		// Workspace URL number.
		// You can view this if you go to 'my tasks' in a
		// workspace and copy the numbered part of the url.
		$output = "54321"; 

	if($input == "12121") // workspace ID
		$output = "34343"; // workspace URL number

	return $output;
}

?>
