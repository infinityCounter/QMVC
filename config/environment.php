<?php

/**
* environment.php configures environment error reporting
* 
* Sets state of error reporting based on the DEVELOPMENT_ENVIRONMENT boolean variable
*/


if(DEVELOPMENT_ENVIRONMENT){
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

?>