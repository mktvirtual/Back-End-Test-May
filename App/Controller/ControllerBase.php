<?php

namespace App\Controller;

use App\View;
use App\Model;

class ControllerBase  {
    public function view($path, $vars = []) {
        $vars['session'] = $_SESSION;
        if (is_array($vars) && count($vars) > 0) extract($vars);
        require_once VIEWS . $path  . '.php';
    }
    protected function isAuth() {
        if (!isset($_SESSION['user'])) {
            session_destroy();
            unset($_SESSION['user']);
            redirect('/login');
            exit();
        }
    }
    public function index() {
        self::view('index/index', []);
    }
    public function notFound() {
        self::view('error/404');
    }
}