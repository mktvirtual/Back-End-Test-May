<?php
namespace mktInstagram\Controller;

abstract class BaseController
{
    protected $registry;

    public function __construct($registry)
    {
        $this->registry = $registry;
    }

    /*
    * @todos os controllers devem ter uma função/método index()
    */
    abstract public function index();
}
