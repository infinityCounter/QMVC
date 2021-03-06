<?php

namespace App;

require_once('constants.php');
require_once(QMVC_ROOT . 'AppConfig.php');

use QMVC\Base\AppConfig;

// Can only upload these file types now
AppConfig::whitelistUploadMIMEList([
    'jpg' => 'image/jpg',
    'jpg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'pdf' => 'application/pdf',
]);

// All uploaded files will be moved to this directory
// AppConfig::setUploadDirectory(dirname(__DIR__) . '/uploads');

?>