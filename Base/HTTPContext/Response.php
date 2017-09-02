<?php

namespace QMVC\Base\HTTPContext;

use QMVC\Base\Helpers\Helpers as Helpers;
use QMVC\Base\Constants\Constants as Constants;
use QMVC\Base\Templating\View as View;

class Response
{
    private $responseType;
    private $responseHeaders;
    private $responseStatusCode;
    private $responseBody;

    const DEF_FILESTREAM_HEADERS = [
        'Content-Description' => 'File Transfer',
        'Content-Type' => 'application/octet-stream',
        'Content-Length' => '',
        'Content-Disposition' => 'attachment; filename=',
        'Expires' => 0,
        'Cache-Control' => 'must-revalidate',
        'Pragma' => 'Public' // Left for pre HTTP\1.1 clients
    ];

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

    public function setResponseType(int $respType)
    {
        if(!Helpers::isValidRespBodyType($respType))
            throw new InvalidArgumentException("{$respType} is not a valid body type. Must be either FILESTREAM, VIEW, or JSON");
        $this->responseType = $respType;
    }

    public function getResponsetype()
    {
        return $this->responseType;
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

    public function setStatusCode(int $statusCode)
    {
        if(!Helpers::isValidStatusCode($statusCode))
            throw new InvalidArgumentException("{$statusCode} is not a valid HTTP Response Status Code.");
        $this->responseStatusCode = $statuscode;
    }

    public function getStatusCode()
    {
        return $this->responseStatusCode;
    }
}
?>;