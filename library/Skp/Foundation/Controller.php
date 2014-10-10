<?php
namespace Skp\Foundation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

abstract class Controller
{

    /**
     * @var Request
     */
    protected $request;

    protected $viewEngine;

    protected $layout;

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function render($name, array $params)
    {
        $engine = $this->getViewEngine();

        $content = $engine->render($name, $params);

        if (!empty($this->layout)) {
            $content = $engine->render($this->layout, array_merge(['content' => $content], $params));
        }

        return $content;
    }

    public function setViewEngine(EngineInterface $engine)
    {
        $this->viewEngine = $engine;
    }

    public function getViewEngine()
    {
        if (!$this->viewEngine) {
            $this->viewEngine = new PhpEngine(
                new TemplateNameParser(),
                new FilesystemLoader(APP_PATH . 'views/%name%')
            );
        }

        return $this->viewEngine;
    }

} 