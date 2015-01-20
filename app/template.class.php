<?php
namespace mktInstagram;

class Template
{
    private $registry;
    private $vars = array();
    private $layout;
    private $view;
    
    public function __construct($registry)
    {
        $this->registry = $registry;
    }

    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    public function show($name)
    {
        $default_layout = __SITE_PATH . '/views/layouts/default.php';
        $path = __SITE_PATH . '/views' . '/' . $name . '.php';

        if (!file_exists($default_layout)) {
            throw new \Exception('Layout não encontrado em ' . $default_layout);
            return false;
        }

        if (!file_exists($path)) {
            throw new \Exception('View não encontrada em ' . $path);
            return false;
        } else {
            $this->view = $path;
        }

        # Carregamos as variáveis
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }

        $content = $this->getView();
        include ($default_layout);
    }

    private function getView()
    {
        # Extraimos todas as variáveis
        extract($this->vars);

        ob_start();
        include ($this->view);
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
