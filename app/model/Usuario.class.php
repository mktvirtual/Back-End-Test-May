<?php

class Usuario {

    const IDENTIFIER = '_USER_';

    protected $user = false;

    public function __construct() {
        if (session_id() == '') {
            session_start();
        }
        if (!isset($_SESSION[self::IDENTIFIER])) {
            $_SESSION[self::IDENTIFIER] = array();
        }
        $this->user = &$_SESSION[self::IDENTIFIER];
    }

    public function is_logged() {
        return !empty($this->user);
    }

    public function login() {
        extract($_POST);

        $userDAO = new UsuarioModel();
        $user = $userDAO->read(array(
            'where' => "`username` = '$username' AND `password` = '$password'"
        ));

        if (!$user)
            return false;

        unset($user->password);

        $this->user = $user;

        return true;
    }
    
    public function forece_login($userID) {
        $userDAO = new UsuarioModel();
        $user = $userDAO->read(array(
            'where' => "`id` = $userID"
        ));

        if (!$user)
            return false;

        unset($user->password);

        $this->user = $user;

        return true;
    }

    public function logout() {
        $this->user = false;
    }

    public function getID() {
        return $this->user->id;
    }

    public function get_user_data() {
        if (!$this->is_logged())
            return false;

        $data = new stdClass();
        $data->nome = $this->user->nome;
        $data->email = $this->user->email;
        $data->username = $this->user->username;

        return $data;
    }

}
