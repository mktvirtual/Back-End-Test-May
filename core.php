<?php

class core {

    public $dataBases = array(
        "arquivos",
        "comentarios",
        "users"
    );
    //Controlador
    public $controller = null;
    //Ação a ser executada
    public $action = null;
    //Layout
    public $layout = "desktop";
    //Conteudo
    public $conteudo = null;
    //Dados do post
    public $data;
    //Classe do Facebook
    public $fbClass = null;
    //Classe de upload
    public $uploadClass = null;
     //Pasta onde ficarão os arquivos
    public $uploadPath = null;
    //token do facebook
    public $token = null;
    //variaveis pra view
    public $viewVars = null;
    //Perfil do usuário
    public $user_profile = null;

    public function __construct() {
        //carregas os db
        require_once ROOT . "/app/classes/db.php";
        foreach ($this->dataBases as $db) {
            if (file_exists(DB . $db . ".php")) {
                require_once DB . $db . ".php";
                $this->$db = new $db;
            }
        }
        //carrega api facebook
        require_once ROOT . "/app/classes/SDKFacebook/facebook.php";
        $this->fbClass = new Facebook(array("appId" => "214519332038882", "secret" => "a3dd5d4327cf30b941f718e347ce9991", "fileUpload" => false));
        $this->setVar("loginUrl", $this->fbClass->getLoginUrl(array("redirect" => "http://shareup.syntex.com.br/user/login/", "scope" => "email")));
        $this->setVar("logoutUrl", $this->fbClass->getLogoutUrl(array("next" => "http://shareup.syntex.com.br/user/logout/")));
        $this->auth();
        $this->setVar("userData", $this->user_profile);
        
        require_once ROOT . "/app/classes/upload.php";
        $this->uploadClass = new upload();
        
        $this->uploadPath = ROOT."/app/webroot/usersFiles/";
        
        if (!empty($_POST)) {
            $this->data = array_merge_recursive($_POST, $_FILES);
        }
        
    }

    public function auth() {
        $this->user_profile = $this->fbClass->getUser();
        $this->token = $this->fbClass->getAccessToken();
        if ($this->user_profile) {
            try {
                $this->user_profile = $this->fbClass->api('/me');
            } catch (FacebookApiException $e) {
                echo $e->getMessage();
                $this->user_profile = null;
            }
        } else {
            
        }
    }

    public function isAuth() {
        if (!empty($this->user_profile)) {
            return true;
        } else {
            return false;
        }
    }

    public function render() {
        if (file_exists(VIEWS . $this->controller . "/" . $this->action . ".php")) {
            echo $this->layout($this->view(VIEWS . $this->controller . "/" . $this->action . ".php"));
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    }

    public function view($arquivo) {
        foreach ($this->viewVars as $var => $value) {
            ${$var} = $value;
        }
        require_once ROOT."/app/classes/postsHelper.php";
        $postsHelper = new postsHelper();
        ob_start();
        include $arquivo;
        $output = ob_get_clean();
        return $output;
    }

    public function layout($conteudo) {
        $this->conteudo = $conteudo;
        return $this->view(ROOT . "/app/layouts/" . $this->layout . ".php");
    }

    public function setVar($var, $value = null) {
        if (!is_null($value)) {
            $this->viewVars[$var] = $value;
        }
    }

}

?>
