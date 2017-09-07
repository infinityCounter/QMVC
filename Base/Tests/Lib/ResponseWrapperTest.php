<?php

namespace QMVC\Base\Tests\Lib;

use PHPUnit\Framework\TestCase;

use QMVC\Base\Lib\ResponseWrapper;
use QMVC\Base\HTTPContext\Response;
use QMVC\Base\HTTPContext\Request;
use QMVC\Base\Constants\Constants;
use QMVC\Base\Security\Sanitizers;
use QMVC\Base\Routing\Router;
use QMVC\Base\Routing\Route;

class MockHandler
{
    public function handleRequest(Request $request)
    {
        return $request->name;
    }
}

class ResponseWrapperTest extends TestCase
{
    public function testWrapper()
    {
        $request = new Request();
        $request->setURI('/qmvc/test/lib/responsewrapper');
        $request->setHTTPType(Constants::GET);
        $request->setHeaders([
            'testHeader' => 'This is the header' 
        ]);
        $name = 'My name is QMVC';
        $request->setBodyArgs([
            'name' => $name
        ]);
        $request->setQueryStringArgs([]);

        $mockHandler = new MockHandler();
        $wrapper = new ResponseWrapper($mockHandler);
        $response = $wrapper->invoke($request);

        $this->assertTrue(is_a($response, Response::class) && $response->getBody() === $name);
    }
}

?>