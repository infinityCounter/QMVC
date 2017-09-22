<?php

namespace QMVC\Base\Tests\HTTPContext;

use PHPUnit\Framework\TestCase;

use QMVC\Base\Constants;
use QMVC\Base\HTTPContext\Response;
use QMVC\Base\Templating\View;

class ResponseTest extends TestCase
{
    public function testConstructor()
    {
        $this->assertTrue(is_a(new Response(), Response::class));
    }    

    public function testSetBodyWithArray()
    {
        $response = new Response();
        $body = ['output' => 'testing'];
        $response->setBody($body);
        $this->assertEquals($body, $response->getBody());
    }

    public function testSetBodyWithObject()
    {
        $response = new Response();
        $body = new \stdclass;
        $body->otuput = 'testing';
        $response->setBody($body);
        $this->assertEquals($body, $response->getBody());
    }

    public function testSetBodyWithView()
    {
        $response = new Response();
        $body = new View();
        $response->setBody($body);
        $this->assertEquals($body, $response->getBody());
        $this->assertTrue($response->getResponseType() === Constants::HTML_RESP);
    }
}

?>