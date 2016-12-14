<?php
/**
* definitions.php defines global constants for the project
*
*/
define('DEVELOPMENT_ENVIRONMENT', true); // Set to false for production
define('PROTOCOL', '//'); //Automatically sets protocol to detected protocol
define('DOMAIN', $_SERVER['HTTP_HOST']); //Get domain name
define('URL_SUB_FOLDER', str_replace('/public', '', dirname($_SERVER['SCRIPT_NAME']))); //The folder that the project exists in
define('URL', PROTOCOL . DOMAIN . URL_SUB_FOLDER); //The full project path

?>
