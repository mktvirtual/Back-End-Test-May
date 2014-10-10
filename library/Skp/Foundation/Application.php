<?php
namespace Skp\Foundation;

use Illuminate\Config\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Skp\Registry;
use Skp\Routing\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\RouteCollection;

class Application
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var RouteCollection
     */
    protected $routes;

    public function __construct()
    {
        $this->loadConfigs();
        $this->loadPlugins();
    }

    public function run(Request $request = null)
    {
        $this->setRequest(($request === null) ? $this->createNewRequest() : $request);
        $this->loadRoutes();

        $dispatcher = new Dispatcher($this);

        return $dispatcher->dispatch();
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    protected function createNewRequest()
    {
        return Request::createFromGlobals();
    }

    protected function loadRoutes()
    {
        $locator = new FileLocator([APP_PATH]);
        $loader  = new PhpFileLoader($locator);

        $this->routes = $loader->load('routes.php');
    }

    protected function loadConfigs()
    {
        // @todo carregamento auto dos arquivos de config...
        $configs = ['database', 'plugins', 'app'];

        $loader = new FileLoader(new Filesystem(), APP_PATH . 'config');
        $loadedConfigs = [];

        foreach ($configs as $config) {
            $loadedConfigs[$config] = (!isset($loadedConfigs[$config])) ? [] : $loadedConfigs[$config];
            $loadedConfigs[$config] = array_merge($loadedConfigs[$config], $loader->load(APPLICATION_ENV, $config));
        }

        Registry::set('Config', $loadedConfigs);
    }

    protected function loadPlugins()
    {
        $config = \Skp\Registry::get('Config');

        foreach ($config['plugins'] as $plugin => $class) {
            $obj = new $class($this);
            $obj->register();
        }
    }

}