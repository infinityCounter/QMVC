<?php

use PHPUnit\Framework\TestCase;
use QMVC\Base\Routing\Route;
use QMVC\Base\Security\Sanitizers;

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
        $handler = $route->getHandler();
        $handler();
    }
}

?>