<?php

namespace App;
//*


// phpinfo();


require_once(realpath('../Base/Constants.php'));
require_once('../Base/Helpers.php');
require_once('../Base/QMVC.php');
require_once('../Base/Routing/Router.php');

use QMVC\Base\Constants as Constants;
use QMVC\Base\Helpers as Helpers;
use QMVC\Base\QMVC as QMVC;
use QMVC\Base\Routing\Router as Router;

Router::get('/', function(Request $request) {
    return "hello";
});

//QMVC::run();

/*
function sendFileResponse($filePath, $limit = 0)
{   
    header('Cache-control: private');
    header('Content-Type: application/octet-stream');
    header('Content-Length: '.filesize($filePath));
    header('Content-Disposition: filename=dog.jpg');
    flush();
    $file = fopen(realPath($filePath), "r");
    $downloadRate = ($limit > 0) ? $limit : 1024;
    while(!feof($file))
    {
        // send the current file part to the browser
        echo fread($file, round($downloadRate * 1024));
        // flush the content to the browser
        flush();
    }
    fclose($file);
}

sendFileResponse('./assets/images/dog.jpg');
*/
?>