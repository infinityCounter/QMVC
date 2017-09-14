<?php

namespace App;

spl_autoload_register(function ($class) {
    $escaped = str_replace('\\', '/', $class);
    $removedPrefix = str_replace('QMVC', '', $escaped);
    $file = dirname(__DIR__) . $removedPrefix .'.php';
    if (file_exists($file)) {
        require_once($file);
    }
});

use QMVC\Base\Constants;
use QMVC\Base\Helpers;
use QMVC\Base\Security\Sanitizers;
use QMVC\Base\Routing\Router;
use QMVC\Base\QMVC;

Router::get('/', function(Request $request) {
    return 'Hello';
});

QMVC::run();

?>