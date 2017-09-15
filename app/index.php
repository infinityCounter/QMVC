<?php

namespace App;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../Base/QMVC.php');
require_once('./config/routes.php');
require_once('./config/templates.php');

use QMVC\Base\QMVC;

QMVC::run();

?>