<?php

namespace QMVC\Base\Tests\Routing;

use PHPUnit\Framework\TestCase;

use QMVC\Base\Routing\Route as Route;
use QMVC\Base\Routing\Router as Router;

final class RouterTest extends TestCase
{
    public function testRouterMakesRouteFromAnonymousFunc()
    {
        Router::get('/', function(Request $request) {
            return 'Hello';
        });

        $route = Router::getRoute('/');
        $this->assertTrue(is_a($route, Route::class));
    }

    /*public function testRouterAddRoute()
    {
        Router::get
    }*/

    /**
    *@dataProvider routerShortHandProvider()
    */
    public function testRouterShortHand($shorthand, $expected)
    {
        call_user_func_array(Router::class . '::' . $shorthand, ['/', function() {
            return 'Hello';
        }]);

        $route = Router::getRoute('/');
        $this->assertTrue($expected == $route->getAllowableActions());
    }

    public function routerShortHandProvider()
    {
        return 
        [
            [
                'get', 
                [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'DELETE' => false
                ]
            ],

            [
                'post', 
                [
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'DELETE' => false
                ]
            ],

            [
                'put', 
                [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'DELETE' => false
                ]
            ],

            [
                'delete', 
                [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'DELETE' => true
                ]
            ],

            [
                'any', 
                [
                    'GET' =>true,
                    'POST' =>true,
                    'PUT' =>true,
                    'DELETE' => true
                ]
            ],
        ];
    }

    /**
    *@dataProvider regexURIPRovider()
    */
    public function testIsURIRegexRoute($actualURI, $speculatedURI, $expectedResult)
    {
        $this->assertEquals($expectedResult, Router::isURIRegexRoute($actualURI, $speculatedURI));
    }

    public function regexURIPRovider()
    {
        return 
        [
            ['/','/', true],
            ['/api/1.0/user/43/friends','/api/{version}/user/{id}/friends', true],
            ['/api/cars/toyota/2005/manual','/api/cars/{make}/{year}/{transmission}', true],
            ['/products/stationary/paper','/animals/{type}/size', false],
            ['/tools/power/saw/mckelin', '/tools/power/{type}/{brand}', true], 
            ['/samsung/smartphone/galaxys6', '/{brand}/smartphone/{model}', true],
            ['/vehicle/sea/yahct/100ft', '/vehicle/sea/boat/100ft', false]
        ];
    }
}


?>