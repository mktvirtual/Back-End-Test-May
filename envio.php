<?php

define('ROOT', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

require ROOT.DS.'vendor'.DS.'autoload.php';
$mkt = new Mkt\Face();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
 $up = new Mkt\Galeria();
 $up->nome      = $_FILES['file']['name'];   // nome da imagem enviada do form
 $up->tmp_name  = $_FILES['file']['tmp_name'];// arquivo temporário
 $up->legenda = addslashes($_POST['legen']);
 $up->uid = $mkt->infoUser()["id"];
 $up->uploadArquivo();
}


//$mkt->Sair();
header("Location: index.php");