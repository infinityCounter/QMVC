<?php

namespace QMVC\Base\HTTPContext;

use QMVC\Base\Constants\Constants as Constants;
use QMVC\Base\Templating\View as View;

class Response
{
    private $responseType;
    private $responseHeaders;
    private $responseStatusCode;
    private $responseBody;
    private $bodyType;

    function __construct($body = null, array $headers = [], int $statusCode = null)
    {
        $this->setBody($body);
        $this->setHeaders($headers);
        $this->setStatusCode($statusCode);
    }

    public function setBody($body)
    {
        /*AUTODETECTION OF BODY TYPE*/
        if(is_a($body, FileResponse::class))
        {
            $this->setResponseType(Constants::FILESTREAM_RESP);
            $this->responseBody = $body;
        }
        else if(is_a($body, View::class))
        {
            $this->setResponseType(Constants::VIEW_RESP);
            $this->responseBody = $body;
        }
        else 
        {
            // Anything other than Files and Views will be json encoded
            $this->setResponseType(Constants::JSON_RESP);
            $cleanedBody = Sanitizers::cleanInputStr(json_encode($body), false, true);
            $this->responseBody = $body;
        }
    }

    public function getBody()
    {
        return $this->responseBody;
    }

    public function setHeaders(array $uncleanedHeaders)
    {
        $uncleanedHeaderKeys = array_keys($uncleanedHeaders);
        $cleanedKeys = array_map(function($uncleanKey)
        {
            return Sanitizers::cleanInputStr((string)$uncleanKey, false, true);
        }, $uncleanedHeaderKeys);

        $cleanedValues = array_map(function($uncleanValue)
        {
            return Sanitizers::cleanInputStr((string)$uncleanValue, false, true);
        }, $uncleanedHeaders);
        $this->responseHeaders = array_combine($cleanedKeys, $cleanedValues);
    }
}
?>