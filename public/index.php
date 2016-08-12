<?php
/**
 * Index do site cópia do Instagran
 * @author Níkolas Nunes Fernandes (05/08/2016)
 */
// Definindo o caminho que deverá buscar as classes
defined('APPLICATION_PATH') || define('APPLICATION_PATH',realpath(dirname(__FILE__) . '/../modules'));
set_include_path(implode(PATH_SEPARATOR,array(realpath(APPLICATION_PATH),get_include_path())));

// Buscando as dependências
require_once APPLICATION_PATH . '/conf/dependencies.php';
$config = require_once APPLICATION_PATH . '/conf/settings.php';

// Tratando o que vai ser recebido por GET
$controller = "Index";
$action = "index";
$layout = "main";
$content = "";
preg_match_all('/\/([a-z-0-9]+)/', $_SERVER['REQUEST_URI'], $matches);
$params = array();
if(isset($matches[1][0])){
	foreach($matches[1] as $k => &$param){
		if($k == 0) $controller = ucfirst($param);
		if($k == 1) $action = $param;
		if($k > 1 && ($k+2)%2) $params[$matches[1][$k-1]] = $param;
	}
}
$args = array();
try {
	// Definição do layout
	$defined = defineLayout();
	resolveDependencies();
	$current = new $controller();
	$actionCurrent = $action."Action";
	$args["main"] = APPLICATION_PATH . "/views/" . $defined . ".hp";
	$args["content"] = APPLICATION_PATH . "/views/" . strtolower($controller) . "/" . $action . ".hp";
	$current->$actionCurrent($args);
} catch (Exception $e) {
	// Bloco para tratar erros, como página inexistente
	require_once APPLICATION_PATH . "/controllers/Error.php";
	$current = new Error();
	$args["content"] = str_replace("%%content%%",$e->getMessage(),file_get_contents(APPLICATION_PATH ."/views/error.hp"));
	$current->indexAction($args);
}
?>
