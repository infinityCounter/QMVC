<?php

namespace QMVC\Base\Constants;

class Constants
{
    const VERSION = 2.0;

    const POST = 'POST';
    const GET  = 'GET';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    const HTTP = 'HTTP';
    const HTTPS = 'HTTPS';

    const JSON_HEADER = 'application/json';
    const CONTENT_TYPE = 'CONTENT_TYPE';
    const PHP_INPUT = 'php://input';

    const HANDLER_METHOD_SIG = 'handleRequest';

    const DELIM_URI = '/';

    const FILESTREAM_RESP = 0;
    const HTML_RESP = 1;
    const JSON_RESP = 2;

    const VALID_URI_CHARSET = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&'()*+,;=`";
}

?>