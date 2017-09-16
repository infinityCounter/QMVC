<?php

namespace App;

require_once('./config/constants.php');
require_once('./config/routes.php');
require_once('./config/templates.php');
require_once('./config/uploads.php');
require_once(QMVC_ROOT . 'QMVC.php');

use QMVC\Base\QMVC;

QMVC::run();

?>