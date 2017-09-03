<?php

use PHPUnit\Framework\TestCase;
use QMVC\Base\Routing\Route;
use QMVC\Base\Security\Sanitizers;

final class mock {

    const OUTPUT = 'testing';

    public static function handleRequest(Request $request)
    {
                return self::OUTPUT;
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
        $this->expectOutputString($outputStr);
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
        $handler = $route->callHandler();
    }

    public function testInvokeClassHandler()
    {
        $outputStr = 'Hello World';
        $this->expectOutputString($outputStr);
        $route = new Route('/', [], mock::class);
        $handler = $route->callHandler();
    }
}

?>