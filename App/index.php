<?php

namespace App;

require_once('./Config/constants.php');
require_once('./Config/security.php');
require_once('./Config/routes.php');
require_once('./Config/templates.php');
require_once('./Config/uploads.php');
require_once(QMVC_ROOT . 'QMVC.php');

use QMVC\Base\QMVC;

QMVC::run();
?>