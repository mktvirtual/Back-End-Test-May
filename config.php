<?php

/* Constantes */
define('MODELS', 'app/model/');
define('VIEWS', 'app/view/');
define('CONTROLLERS', 'app/control/');
define('HELPERS', 'app/helper/');
define('UPLOADS', 'public/upload/');
define('WIDTH_TO_RESIZE', 630);
define('BASE_URL','instafake');//Caminho do diretório a partir da raiz, se estiver na raiz deixe em branco

/* Banco de Dados */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'instagram');

/* Data e Hora */
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

?>