<?php

require_once(dirname(dirname(__DIR__)) . '/Base/TwigAutoloader.php');
require_once(dirname(dirname(__DIR__)) . '/Base/AppConfig.php');

use QMVC\Base\TwigAutoloader;
use QMVC\Base\AppConfig;

TwigAutoloader::register();

$loader = new \Twig_Loader_Array(array(
    'index' => 'Hello {{ name }}!',
));

$twig = new \Twig_Environment($loader);

AppConfig::setTwigEnvironment($twig);
?>