<?php
//Sets the ROOT_PATJ constant to the root of the project

define('PROTOCOL', '//');
define('DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace('/public', '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', PROTOCOL . DOMAIN . URL_SUB_FOLDER);

?>
