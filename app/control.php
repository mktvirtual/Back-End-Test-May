<?php

class Controller {

    protected $full_page = true;

    public function __construct()
    {
        
    }

    protected function view($nome, $vars = null, $includes = true)
    {
        global $usuario;
        $vars['usuario'] = $usuario->get_user_data();
        
        if (isset($vars)):
            extract($vars);
        endif;

        if ($includes):            
            require_once( VIEWS . "{$nome}.phtml");            
        else:
            require_once( VIEWS . "{$nome}.phtml");
        endif;

        exit;
    }

    public function title($string)
    {
        $this->_params['title'] = "$string | " . SITE_NAME;
    }

    public function keywords($string)
    {
        $this->_params['keywords'] = $string;
    }

    public function description($string)
    {
        $this->_params['description'] = $string;
    }

}

?>