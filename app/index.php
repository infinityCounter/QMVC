<?php
namespace App;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../Base/TwigAutoloader.php');
require_once('../Base/Routing/Middleware.php');
require_once('../Base/Routing/Router.php');
require_once('../Base/QMVC.php');
require_once('../Base/HTTPContext/Request.php');
require_once('../Base/HTTPContext/FileResponse.php');
require_once('../Base/HTTPContext/Response.php');

use QMVC\Base\TwigAutoloader;
use QMVC\Base\HTTPContext\Request;
use QMVC\Base\HTTPContext\Response;
use QMVC\Base\HTTPContext\FileResponse;
use QMVC\Base\Routing\Middleware;
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

Router::get('/doggo', function(Request $request) {
    $fileResponse = new FileResponse('./assets/images/dog.jpg');
    return $fileResponse;
});

class PersonController
{
    public $key = 'value';

    public function handleRequest(Request $request)
    {
        return new self;
    }
}

Router::get('/person', PersonController::class);

class DemoMiddleware extends Middleware
{
    public function invoke(Request $request)
    {
        $resp = $this->next->invoke($request);
        $resp->setBody('Third times the charm');
        return $resp;
    }
}

Router::get('/intercept', function(Request $request)
{
    return "I'm in the clear!";
}, [
    DemoMiddleware::class,
    function($next, Request $request) 
    {
        $resp = $next->invoke($request);
        $resp->setBody('Intercepted Again!');
        return $resp;
    },
    function($next, Request $request) 
    {
        $resp = $next->invoke($request);
        $resp->setBody('Intercepted!');
        return $resp;
    }
]);


QMVC::run();

?>