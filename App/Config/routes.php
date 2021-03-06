<?php

namespace App;

require_once('constants.php');
require_once(QMVC_ROOT . 'HTTPContext/Request.php');
require_once(QMVC_ROOT . 'HTTPContext/FileResponse.php');
require_once(QMVC_ROOT . 'HTTPContext/Response.php');
require_once(QMVC_ROOT . 'Templating/View.php');
require_once(QMVC_ROOT . 'Routing/Middleware.php');
require_once(QMVC_ROOT . 'Routing/Router.php');

use QMVC\Base\HTTPContext\Request;
use QMVC\Base\HTTPContext\Response;
use QMVC\Base\HTTPContext\FileResponse;
use QMVC\Base\Templating\View;
use QMVC\Base\Routing\Middleware;
use QMVC\Base\Routing\Router;


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
    $fileResponse = new FileResponse(APP_ROOT . '/assets/images/dog.jpg');
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
    return $request->year;;
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

Router::any('/view', function(Request $request)
{
    $view = new View('index', ['name' => $request->name]);
    return $view;
});

Router::post('/upload', function(Request $request){
    return var_dump($request->getBodyArgs());
});


?>