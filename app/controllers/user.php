<?php

class user extends core {
    
    public function verify() {
        if(!$this->isAuth()){
            header("location: /");
        }
    }

    public function index() {
        
    }

    public function login() {
        header('location: /user/add/');
    }

    public function logout() {
        session_destroy();
        header('location: /');
    }

    public function add() {
        if ($this->users->hasUser($this->user_profile["id"])) {
            header('location: /user/panel/');
        } else {
            $this->users->addUser($this->user_profile);
            header('location: /user/panel/');
        }
    }

    public function panel() {
        $this->verify();
        if (!empty($this->data)) {
            if ($this->data["arquivo"]["size"] > 0) {
                $arquivo = $this->uploadClass->uploadFile($this->data["arquivo"], $this->uploadPath);
                if (!empty($arquivo)) {
                    $this->data["arquivo"] = $arquivo;
                    $this->data["users_id"] = $this->user_profile["id"];
                    $this->arquivos->insertArquivo($this->data);
                    //header('location: /user/photo_edit/'.$this->arquivos->getID($arquivo));
                }
            }
        }
        $this->setVar("posts", $this->arquivos->lastPosts($this->user_profile["id"]));
    }

    public function profile($user) {
        $this->setVar("user", $this->users->getProfile($user));
        $this->setVar("lastPosts", $this->arquivos->lastPosts($user));
    }

    public function photo($id) {
        $this->setVar("post",$this->arquivos->post($id));
    }

    public function photo_delete($id) {
        $this->verify();
        $this->arquivos->delete($id, $this->user_profile["id"]);
        header("location: /user/panel/");
    }

    public function photo_edit($id) {
        if (!empty($this->data)) {
            
        }
        $this->setVar("idPhoto", $id);
        $this->setVar("post", $this->arquivos->post($id));
    }

    public function comentario($id) {
        $this->verify();
        if (!empty($this->data)) {
            $this->data["user_id"] = $this->user_profile["id"];
            $this->data["arquivo_id"] = $id;
            $this->comentarios->insert($this->data);
            header("location: /user/photo/$id");
        }
    }

}

?>
