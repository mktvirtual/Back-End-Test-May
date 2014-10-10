<?php
namespace Skp\Plugin;

use Skp\Foundation\Application;

abstract class PluginAbstract
{

    protected $application;

    public function __construct(Application $app)
    {
        $this->application = $app;
    }

    abstract public function register();

} 