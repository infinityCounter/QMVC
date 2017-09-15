<?php
namespace App;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../Base/Routing/Router.php');
require_once('../Base/QMVC.php');
require_once('../Base/HTTPContext/Request.php');
require_once('../Base/HTTPContext/Response.php');

use QMVC\Base\HTTPContext\Request;
use QMVC\Base\HTTPContext\Response;
use QMVC\Base\Routing\Router;
use QMVC\Base\QMVC;

Router::get('/', function(Request $request) {
    return 'QMVC v2.0 ON!';
});

Router::get('/MyNameIs', function(Request $request) {
    return 'Hello ' . $request->name;
});

Router::get('/MyNameIs/{name}', function(Request $request) {
    return 'Hello ' . $request->name;
});

QMVC::run();

?>