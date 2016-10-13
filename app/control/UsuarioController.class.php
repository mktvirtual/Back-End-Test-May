<?php

class UsuarioController extends Controller {

    public function login() {
        $usuario = new Usuario();

        if ($usuario->login()):
            header('Location: '.site_url());
        else:
            header('Location: '.site_url().'?erro=1');
        endif;
    }
    
    public function logout() {
        global $usuario;       

        $usuario->logout();
        
        header('Location: '.site_url());
    }
    
    public function cadastro(){
        $usuario = new Usuario();
        $usuarioModel = new UsuarioModel();
        
        $userID = $usuarioModel->insert($_POST);        
        $usuario->forece_login($userID);
        
        header('Location: '.site_url());
    }

    public function editar(){
        $this->view('editar-conta');
    }
    
    public function update(){
        global $usuario;
        $usuarioModel = new UsuarioModel();
        
        $dados = array_filter($_POST);
        $usuarioModel->update($dados, "`id` = {$usuario->getID()}");
        
        //Forçando a atualizar as informações na verdade
        $usuario->forece_login($usuario->getID());
        
        header('Location: '.make_url('usuario/perfil'));
    }
    
    public function perfil(){
        global $usuario;
        $vars = array();
        $usuarioModel = new UsuarioModel();
        $postModel = new PostModel();
                
        $id = (isset($_GET['u']))?$_GET['u']:$usuario->getID();                
        $usuarioModel->_class = 'Pessoa';//forçando saída do objeto<Pessoa>
        $p  = $usuarioModel->read(array('where' => "`id`={$id}"));
        
        $vars['p'] = $p;
        $vars['posts'] = $postModel->read(array('where' => "`autor`={$id}", 'order' => "`data` DESC", 'limit' => '10'),true);        
        $vars['current_user'] = ($p->id == $usuario->getID());
        
        $this->view('perfil', $vars);
    }
}
