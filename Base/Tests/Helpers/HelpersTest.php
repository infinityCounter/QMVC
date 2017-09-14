<?php

namespace QMVC\Base\Tests\Helpers;

use PHPUnit\Framework\TestCase;

use QMVC\Base\Helpers;

final class HelpersTest extends TestCase
{
    /**
    *@dataProvider HTTPRequestTypeProvider
    */
    public function testValidRequesType($test) 
    {
        $this->assertTrue(Helpers::isValidHTTPRequestType($test));
    }

    public function testInvalidRequestType()
    {
        $this->assertFalse(Helpers::isValidHTTPRequestType('HEAD'));
    }

    public function HTTPRequestTypeProvider()
    {
        return [
            ['GET'],
            ['POST'],
            ['PUT'],
            ['DELETE']
        ];
    }
} 

?>