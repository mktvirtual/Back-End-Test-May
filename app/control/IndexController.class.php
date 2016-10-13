<?php

class IndexController extends Controller{
    
    public function main(){        
        global $usuario;
        
        if($usuario->is_logged()):
            $this->index();
        else:    
            $this->login();
        endif;
    }
    
    public function login(){
        $this->view('login');
    }
    
    public function index(){
        global $usuario;
        $vars = array();
        
        $postModel = new PostModel();
        $usuarioModel = new UsuarioModel();
        $usuarioModel->_class = 'Pessoa';
        
        $autores = $usuarioModel->read(array(
            'order' => "RAND()",
            'limit' => '10'
        ));
        
        foreach ($autores as $autor):
            $autor->load_tree_posts();
        endforeach;
        
        $vars['autores'] = $autores;        
        
        $this->view('index', $vars);
    }
    
}
