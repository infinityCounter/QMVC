<?php

namespace App;

require_once('../Base/Routing/Router.php');
require_once('../Base/QMVC.php');

use QMVC\Base\Routing\Router;
use QMVC\Base\QMVC;

Router::get('/', function(Request $request) {
    return 'QMVC v2.0 ON!';
});

Router::get('/MyNameIs', function(Request $request) {
    return 'Hello ' . $request->name;
});

QMVC::run();

?>