<?php

namespace QMVC\Base\HTTPContext;

use QMVC\Base\Constants;

class Response
{
    private $responseType;
    private $responseHeaders;
    private $responseStatusCode;
    private $responseBody;

    function __construct($body = null, $headers = [], $statusCode = null, $type = JSON)
    {
        $this->setBody($body);
        $this->setHeaders($headers);
        $this->setStatusCode($statusCode);
        $this->setResponseType($type);
    }
}
?>

A response has:

- Status Code
- Body
- Headers

Body can be:
-A regular string
-JSON
-XML
-OR a file