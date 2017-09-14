<?php

namespace App;

require_once('../Base/Routing/Router.php');
require_once('../Base/QMVC.php');

use QMVC\Base\Routing\Router;
use QMVC\Base\QMVC;

Router::get('/', function() {
    return 'Hello';
});

QMVC::run();

?>