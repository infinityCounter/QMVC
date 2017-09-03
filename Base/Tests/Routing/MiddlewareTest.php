<?php

use PHPUnit\Framework\TestCase;

use QMVC\Base\Routing\Route;
use QMVC\Base\Routing\Middleware;

class MiddlewareTest extends TestCase
{
    public function testConstructor()
    {
        $routeCallback = function() 
        {
            echo 'This is the route callback';
        };
        $route = new Route('/', [], $routeCallback);
        $midwareCallback = function()
        {
            echo 'This is the middleware callback';
        };
        $midware = new Middleware($route->getHandler(), $midwareCallback);
        $this->assertTrue($midware->getNext() === $routeCallback);
    }
}

?>