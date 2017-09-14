<?php

namespace QMVC\Base;

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
    const HTTP_RESP_CODES = array(
            100,101,102,
            200,201,202,203,204,205,206,207,208,226,
            300,301,302,303,304,305,306,307,308,
            100,401,402,403,404,405,406,407,408,409,410,411,412,413,414,
            415,416,417,418,
            421,422,423,424,426,428,429,431,451,
            500,502,503,504,506,507,508,510,511
    );

    const HANDLER_METHOD_SIG = 'handleRequest';

    const DELIM_URI = '/';

    const FILESTREAM_RESP = 0;
    const HTML_RESP = 1;
    const JSON_RESP = 2;

    const VALID_URI_CHARSET = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&'()*+,;=`";
    
}

?>