<?php

namespace QMVC\Base;

use QMVC\Base\Constants;
use QMVC\Base\Routing\Router;
use QMVC\Base\HTTPContext\Request;
use QMVC\Base\HTTPContext\Response;
use QMVC\Base\HTTPContext\FileResponse;
use QMVC\Base\Templating\View;

final class QMVC
{
    public static function run()
    {
        $request = Request::BuildRequest();
        $route = Router::getRoute($userRequest->getURI());
        $response = null;
        if (!isset($route)) 
            $response = Response::NotFound();
        else
            $response = $route->execPipline($request);
        if(is_a($response, Response::class))
            $response = new Response($response);
        self::sendStatusCode($response->getStatusCode());
        self::sendHeaders($response->getHeaders());
        if($response->getResponseType() === Constants::JSON_RESP)
            self::sendStringResponse($response->getBody());
        else if($response->getResponseType() === Constants::FILESTREAM_RESP)
            self::sendFileResponse($response->getBody());
        else if($response->getResponseType() === Constants::HTML_RESP)
            self::sendViewResponse($response->getBody());
    }

    private static function sendStatusCode(int $statusCode)
    {
        // When called with a strin argument with no colon, only the status code and phrase is sent
        header('x', true, $statusCode());
    }

    private static function sendHeaders(array $respHeaders)
    {
        foreach ($respHeaders as $headerKey => $headerValue) {
            header($headerKey . ": " . $headerValue);
        }
    }

    private static function sendFileResponse(FileResponse $fileResponse)
    {
        $filePath = realPath($fileResponse->getFilePath());
        if(!$filePath || !file_exists($filePath) || is_dir($filePath))
            throw new InvalidArgumentException("Cannot find file {$filePath}.");
        flush();
        $file = fopen($filePath, "r");
        $downloadRate = ($fileResponse->isLimited()) ? $fileResponse->getDownloadLimit() : 1024;
        while(!feof($file))
        {
            // send the current file part to the browser
            echo fread($file, round($downloadRate * 1024));
            // flush the content to the browser
            flush();
        }
        fclose($file);
    }

    private static function sendStringResponse(string $jsonBody)
    {
        echo $jsonBody;
        flush();
    }

    private static function sendViewResponse(View $view)
    {
        echo $view->render();
        flush();
    }
}

?>