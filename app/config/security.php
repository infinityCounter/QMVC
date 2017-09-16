<?php

namespace App;

require_once('constants.php');
require_once(QMVC_ROOT . 'Constants.php');
require_once(QMVC_ROOT . 'AppConfig.php');

use QMVC\Base\Constants;
use QMVC\Base\AppConfig;

AppConfig::useOnlyHTTPS(true);
AppConfig::UseOnlyHTTPSSubdomains(true);
AppConfig::setSTSTime(60);
AppConfig::setContentSecurityPolicy("default-src 'self'");

?>