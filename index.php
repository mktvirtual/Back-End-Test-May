<?php

require_once 'config.php';
require_once 'app/model.php';
require_once 'app/control.php';
require_once 'app/autoload.php';
require_once 'app/system.php';
require_once 'app/functions.php';

$system = System::singleton();
$system->run();
?>