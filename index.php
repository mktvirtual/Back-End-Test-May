<?php 
session_name('INSTAMKT');
session_start();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';
require __DIR__ . '/helper.php';
require __DIR__ . '/database.php';
require __DIR__ . '/routes.php';

$database = new \App\Database;

use \App\Controller;
use \App\Controller\ControllerBase;

$req = $_SERVER['REQUEST_URI'];
$uri = explode('/', $req);
$controller = $uri[1] ?? false;
$action = isset($uri[2]) && !empty($uri[2]) ? $uri[2] : 'index';
$params = [];
//pre(['controller' => $controller, 'action' => $action]);
for ($i = 3; $i < count($uri); $i++) {
    $params[] = $uri[$i];
}
$params = strlen(implode('', $params)) > 0 ? $params : false;

function displayController() {
    global $controller, $action, $params;

    $user = \App\Model\User::getUser($controller);
    if ($user) {
        if ($action == 'post' && !empty($params)) {
            $controller = 'user';
            $action = 'post';
            $params = $params[0];
        } else if ($action == 'index' && empty($params)) {
            unset($user['password']);
            $controller = 'user';
            $action = 'profile';
            $params = $user;
        }
    }
    if (file_exists(__DIR__ . '/App/Controller/' . camelCase($controller) . 'Controller.php')) {
        eval("\$c = new \\App\\Controller\\" . camelCase($controller) . "Controller;");
        eval("\$c->$action(\$params);");
    } else {
        ControllerBase::notFound();
    }
}

if ($req[strlen($req)-1] == "/" && strlen($req) > 1) {
    $req = substr($req, 0, strlen($req)-1);
}

if (isset($routes[$req])) {
    $e = explode('/', $routes[$req]);
    $controller = $e[0];
    $action = $e[1];
    displayController();
} else {
    if (!$controller) {
        ControllerBase::index();
    } else {
        displayController();
    }
}