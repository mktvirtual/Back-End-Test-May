<?php
function addslashes_files_recursive($array){
	$return = array();
	foreach($array as $id => $value){
		if(is_array($value)){
			$return[$id] = addslashes_files_recursive($value);
		} else {
			$return[$id] = addslashes($value);
		}
	}
	return $return;
}
session_start();
$data = array();
if(isset($_POST)) $data['POST'] = $_POST;
if(isset($_COOKIE)) $data['COOKIE'] = $_COOKIE;
if(isset($_GET)) $data['GET'] = $_GET;
if(isset($_SESSION)) $data['SESSION'] = $_SESSION;
if(isset($_FILES)) $data['FILES'] = $_FILES;
$url = explode("/", $_SERVER["REQUEST_URI"]);

use Vendor\Controller;
if (empty($url[1])) {
	$url[1] = "Index";
}

if (file_exists('../controller/' . $url[1] . ".php")) {
	include '../controller/' . $url[1] . ".php";
	$class = 'Vendor\\Controller\\'.$url[1];
	if (class_exists($class)) {
		$controller = new $class;
		if (!isset($url[2]) || empty($url[2])) {
			$url[2] = "index";
		} else {
			$url[2] = preg_replace('/^(\w*)[\s\S]*$/', '$1', $url[2]);
		}
		$controller->controller = $url[1];
		$controller->action = $url[2];
		$controller->data = $data;
		if (method_exists($controller, $controller->action)) {
			$controller->{$controller->action}();
			$controller->render();
		} else {
			header("HTTP/1.0 404 Not Found");
		}
	};
} else {
	header("HTTP/1.0 404 Not Found");
}
?>