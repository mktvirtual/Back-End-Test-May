<?php
namespace Skp\Component\HttpKernel\Controller;

use Symfony\Component\HttpFoundation\Request;

class ControllerResolver extends \Symfony\Component\HttpKernel\Controller\ControllerResolver
{

    public function getController(Request $request)
    {
        if (!$controller = $request->attributes->get('_controller')) {
            return false;
        }

        if (is_array($controller)) {
            return $controller;
        }

        if (is_object($controller)) {
            if (method_exists($controller, '__invoke')) {
                return $controller;
            }

            throw new \InvalidArgumentException(sprintf('Controller "%s" for URI "%s" is not callable.', get_class($controller), $request->getPathInfo()));
        }

        if (false === strpos($controller, ':')) {
            if (method_exists($controller, '__invoke')) {
                $controller = new $controller();
                $controller->setRequest($request);

                return new $controller();
            } elseif (function_exists($controller)) {
                return $controller;
            }
        }

        $callable = $this->createController($controller);

        if (!is_callable([$callable[0], $callable[1]])) {
            throw new \InvalidArgumentException(sprintf('Controller "%s" for URI "%s" is not callable.', $controller, $request->getPathInfo()));
        }

        $callable[0]->setRequest($request);

        return $callable;
    }



}