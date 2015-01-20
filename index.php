<?php

session_start();
error_reporting(E_ALL);

# Define o caminho do site
$site_path = realpath(dirname(__FILE__));

$arr = explode('/', $_SERVER['PHP_SELF']);
$uri = 'http://' . $_SERVER['HTTP_HOST'];
for ($i=1; $i<sizeof($arr) - 1; $i++) {
    if ($i == 1) {
        $uri = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $arr[$i];
    } else {
        $uri .= '/' . $arr[$i];
    }
}

$asset_path = $uri . '/assets';

define('__SITE_PATH', $site_path);
define('__ASSETS_PATH', $asset_path);
define('__SITE_URL', $uri);

# Inclusão do arquivo init.php
include 'vendor/autoload.php';
include 'vendor/autoload_classes.php';

$config = new mktInstagram\Config();

# Start Facebook Session
Facebook\FacebookSession::setDefaultApplication($config->getAppId(), $config->getSecretId());

$registry->router = new mktInstagram\Router($registry);
$registry->template = new mktInstagram\Template($registry);

# Facebook > Login Helper Init
$registry->facebookHelper = new Facebook\FacebookRedirectLoginHelper(__SITE_URL . '/retorno');

$registry->router->setPath(__SITE_PATH . '/controller');
$registry->router->loader();
