<?php

define('ROOT', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

require ROOT.DS.'vendor'.DS.'autoload.php';

$mkt = new Mkt\Face();

$mkt->Sair();
header("Location: index.php");