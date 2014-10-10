<?php
namespace Skp\Routing;

use Skp\Foundation\Application;
use Skp\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class Dispatcher
{
    protected $application;

    public function __construct(Application $app)
    {
        $this->application = $app;
    }

    public function dispatch()
    {
        $matcher = new UrlMatcher($this->application->getRoutes(), new RequestContext());

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new RouterListener($matcher));

        $resolver = new ControllerResolver();
        $kernel   = new HttpKernel($dispatcher, $resolver);

        $response = $kernel->handle($this->application->getRequest());
        $response->send();

        $kernel->terminate($this->application->getRequest(), $response);
    }

} 