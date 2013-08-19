<?php
session_start();
//Pasta Raiz do Sistema
DEFINE("ROOT", dirname(dirname(dirname(__FILE__))));
//Pasta onde ficam os Controladores
DEFINE("CONTROLLERS", ROOT . "/app/controllers/");
//pasta onde estão os aruivos dos db;
DEFINE("DB", ROOT . "/app/db/");
//Pasta onde ficam as Views
DEFINE("VIEWS", ROOT . "/app/views/");
//Pasta onde ficam os layouts
DEFINE("LAYOUTS", ROOT . "/app/layouts/");

$here = explode("/", $_SERVER["REQUEST_URI"]);
require_once(ROOT . "/core.php");

if (empty($here[1])||$here[1]{0}=="?") {
    $here[1] = "home";
}
if (file_exists(CONTROLLERS . $here[1] . ".php")) {
    include CONTROLLERS . $here[1] . ".php";
    if (class_exists($here[1])) {
        $controller = new $here[1];
        if (empty($here[2])) {
            $here[2] = "index";
        }

        $controller->controller = $here[1];
        $controller->action = $here[2];

        if (method_exists($controller, $controller->action)) {
            $controller->{$controller->action}($here[3]);
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    };
} else {
    header("HTTP/1.0 404 Not Found");
}

$controller->render();
?>