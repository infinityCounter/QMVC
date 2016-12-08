<?php

/*Config file containing details of project environment configuration*/

//Default to a debug invronment
define('DEVELOPMENT_ENVIRONMENT', true);

if(DEVELOPMENT_ENVIRONMENT){
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

?>