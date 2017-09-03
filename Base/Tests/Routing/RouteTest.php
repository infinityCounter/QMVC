<?php

use PHPUnit\Framework\TestCase;
use QMVC\Base\Security\Sanitizers;
use QMVC\Base\HTTPContext\Request;
use QMVC\Base\Routing\Route;

final class mock {

    const OUTPUT = 'testing';

    public static function handleRequest(Request $request)
    {
        echo self::OUTPUT;
    }
}

class RouteTest extends TestCase
{
    public function testGetURI()
    {
        $URI = '/test';
        $route = new Route($URI, [], function(){ return 'Hello World'; });
        $this->assertEquals($route->getURI(), Sanitizers::cleanURI($URI));
    }

    public function testGetHandler()
    {
        $outputStr = 'Hello World';
        $callback = function() use ($outputStr) { echo $outputStr; };
        $route = new Route('/', [], $callback);
        $this->assertEquals($callback, $route->getHandler());
    }

    public function testInvokeFuncHandler()
    {
        $outputStr = 'Hello World';
        $this->expectOutputString($outputStr);
        $callback = function() use ($outputStr) { echo $outputStr; };
        $route = new Route('/', [], $callback);
        $request = new Request();
        $route->callHandler($request);
    }

    public function testInvokeClassHandler()
    {
        $this->expectOutputString(mock::OUTPUT);
        $route = new Route('/', [], mock::class);
        $request = new Request();
        $route->callHandler($request);
    }
}

?>