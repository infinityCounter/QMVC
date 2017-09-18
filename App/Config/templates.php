<?php

require_once('constants.php');
require_once(QMVC_ROOT . 'TwigAutoloader.php');
require_once(QMVC_ROOT . 'AppConfig.php');

use QMVC\Base\TwigAutoloader;
use QMVC\Base\AppConfig;

TwigAutoloader::register();

$loader = new \Twig_Loader_Array(array(
    'index' => 'Hello {{ name }}!',
));

$twig = new \Twig_Environment($loader);

AppConfig::setTwigEnvironment($twig);
?>