<?php

use QMVC\Base\Routing\Router as Router;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
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