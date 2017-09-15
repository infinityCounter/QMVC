<?php

namespace QMVC\Base;

require_once(__DIR__ . '/Constants.php');
require_once(__DIR__ . '/Helpers.php');
require_once(__DIR__ . '/Security/Sanitizers.php');
require_once(__DIR__ . '/AppConfig.php');
require_once(__DIR__ . '/Templating/View.php');
require_once(__DIR__ . '/Routing/IRequestHandler.php');
require_once(__DIR__ . '/Routing/Middleware.php');
require_once(__DIR__ . '/Routing/Route.php');
require_once(__DIR__ . '/Routing/Router.php');
require_once(__DIR__ . '/HTTPContext/Request.php');
require_once(__DIR__ . '/HTTPContext/Response.php');
require_once(__DIR__ . '/HTTPContext/FileResponse.php');
require_once(__DIR__ . '/Lib/ResponseWrapper.php');

use QMVC\Base\Constants;
use QMVC\Base\Routing\Middleware;
use QMVC\Base\Routing\Route;
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
        $route = Router::getRoute($request->getURI());
        $response = null;
        if (!isset($route)) 
        {
            $response = Response::NotFound();
        }
        else
        {
            $request->setRESTArgs($route->getURI());
            $response = $route->execPipeline($request);
            if(!is_a($response, Response::class))
                $response = new Response($response);
        }
        self::sendStatusCode($response->getStatusCode());
        self::sendHeaders($response->getHeaders());
        if($response->getResponseType() === Constants::FILESTREAM_RESP)
            self::sendFileResponse($response->getBody());
        else if($response->getResponseType() === Constants::HTML_RESP)
            self::sendViewResponse($response->getBody());
        else
            self::sendStringResponse(json_encode($response->getBody()));      
    }

    private static function sendStatusCode(int $statusCode)
    {
        // When called with a strin argument with no colon, only the status code and phrase is sent
        http_response_code($statusCode);
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