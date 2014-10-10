<?php

define('APP_PATH', __DIR__ . '/../app/');
define('POOL_PATH', __DIR__ . '/pool/');
define('CONFIG_PATH', APP_PATH . 'config/');
define('APPLICATION_ENV', (getenv('APPLICATION_ENV')) ?: 'production');

require __DIR__ . '/../vendor/autoload.php';

$app = new Skp\Foundation\Application();
$app->run();