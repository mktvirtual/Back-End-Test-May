<?php
namespace mktInstagram;

class Router
{
    private $registry;
    private $path;
    private $args = array();

    public $file;
    public $controller;
    public $action;

    public function __construct($registry)
    {
        $this->registry = $registry;
    }

    public function setPath($path)
    {
        if (!is_dir($path)) {
            throw new \Exception('Caminho do controller incorreto:' . $path);
        }

        # set the path
        $this->path = $path;
    }

    public function loader()
    {
        # Checa o controller
        $this->getController();
        
        # Se o arquivo não estiver acessível
        if (!is_readable($this->file)) {
            echo $this->file;
            die('404 - Não Encontrado');
        }

        # Inclue o controller
        include $this->file;

        # Cria uma nova instância da classe do controller
        $class = 'mktInstagram\Controller\\' . ucwords($this->controller) . 'Controller';
        $controller = new $class($this->registry);

        # Verifica se a "action" está acessível
        if (!is_callable(array($controller, $this->action))) {
            $action = 'Index';
        } else {
            $action = $this->action;
        }

        # Roda a "action"
        $controller->$action();
    }

    private function getController()
    {
        # Pegamos a action da URL
        $route = (empty($_GET['rturl'])) ? '' : $_GET['rturl'];

        if (empty($route)) {
            $route = 'index';
        } else {
            # Divide a URL
            $parts = explode('/', $route);
            $this->controller = $this->transformToCamelCase($parts[0]);

            if (isset($parts[1])) {
                $this->action = $this->transformToCamelCase($parts[1], 1);
            };
        }

        # Setamos a "action"
        if (empty($this->action)) {
            $this->action = 'Index';
        }

        if (empty($this->controller)) {
            $this->controller = 'Index';
        }

        # Setamos o caminho do arquivo
        $this->file = $this->path . '/' . $this->controller . '_controller.php';
    }

    private function transformToCamelCase($string, $capitalizeFirstCharacter = false, $pos = 0)
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[$pos] = ucwords($str[$pos]);
        }

        return $str;
    }
}
