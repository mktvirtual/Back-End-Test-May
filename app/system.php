<?php
class System {    
    private static $instancia;    
    private static $_url;
    private static $control;
    private static $method;

    private function __construct()
    {
        $this->set_url();
    }

    public static function singleton()
    {
        if (!isset(self::$instancia))
        {
            $c = __CLASS__;
            self::$instancia = new $c;
        }

        return self::$instancia;
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    private function set_url()
    {
        $_GET['url'] = (isset($_GET['url'])) ? $_GET['url'] : '';
        self::$_url = $_GET['url'];
        
        $get = explode('?',$_SERVER['REQUEST_URI']);
        if(isset($get[1])):
            $elements = explode('&', $get[1]);
            foreach($elements as $element):
                $e = explode('=',$element);
                $_GET[$e[0]] = $e[1];
            endforeach;
        endif;        
        
        $fragments = explode('/', self::$_url);
        
        if($fragments[0] == ''):
            self::$control = 'IndexController';
            self::$method = 'main';
        elseif(count($fragments) == 1):
            self::$control = ucfirst($fragments[0]) . 'Controller';
            self::$method = 'main';
        else:    
            self::$control = ucfirst($fragments[0]) . 'Controller';
            self::$method = $fragments[1];
        endif;
    }
    
    public function preload_controllers(){
        $dir = dir(CONTROLLERS);
        while($file = $dir->read()):
            if(strpos($file, '.php'))
                require_once CONTROLLERS.$file;
        endwhile;
    }

    public function run()
    {
        global $usuario;
        $usuario = new Usuario();
        
        $_control = self::$control;
        $_method  = self::$method;
        
        $control = new $_control;
        $control->$_method();        
    }
}

?>