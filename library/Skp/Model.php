<?php

class Model extends \Illuminate\Database\Eloquent\Model
{

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $config = \Skp\Registry::get('Config');
var_dump($config);exit;
        $resolver = new Illuminate\Database\ConnectionResolver();
        $resolver->setDefaultConnection('default');
        $factory = new Illuminate\Database\Connectors\ConnectionFactory(new Illuminate\Container\Container());
        $connection = $factory->make(array(
            'host'     => 'localhost',
            'database' => 'insta_mkt',
            'username' => 'root',
            'password' => '',
            'collation' => 'utf8_general_ci',
            'driver'   => 'mysql',
            'prefix'   => '',
            'charset'  => 'utf8',
        ));

        $resolver->addConnection('default', $connection);
        Illuminate\Database\Eloquent\Model::setConnectionResolver($resolver);
    }

} 