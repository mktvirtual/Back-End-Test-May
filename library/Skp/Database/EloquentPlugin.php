<?php
namespace Skp\Database;

use Illuminate\Pagination\Factory;
use Illuminate\Pagination\Paginator;
use Skp\Plugin\PluginAbstract;
use Illuminate\Container\Container;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentPlugin extends PluginAbstract
{

    public function register()
    {
        $config = \Skp\Registry::get('Config');

        $factory    = new ConnectionFactory(new Container());
        $connection = $factory->make(array(
            'host'     => $config['database']['host'],
            'database' => $config['database']['database'],
            'username' => $config['database']['username'],
            'password' => $config['database']['password'],
            'collation' => 'utf8_general_ci',
            'driver'   => 'mysql',
            'prefix'   => '',
            'charset'  => 'utf8',
        ));

        $resolver = new ConnectionResolver(['default' => $connection]);
        $resolver->setDefaultConnection('default');
        Model::setConnectionResolver($resolver);
    }

}