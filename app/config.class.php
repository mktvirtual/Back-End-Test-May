<?php
namespace mktInstagram;

class Config
{
    protected $defaultDB = null;

    protected $localhost = array(
        'host' => 'localhost',
        'dbName' => 'picture_it',
        'user' => 'root',
        'pass' => 'root'
    );

    protected $producao = array(
        'host' => '',
        'dbName' => '',
        'user' => '',
        'pass' => ''
    );

    public $appId = '333796446826704';
    public $secretId = '4f76d934f9fade9e20626b65c1a3dbfb';

    public function __construct()
    {
        switch ($_SERVER['SERVER_NAME']) {
            case 'localhost':
            case '127.0.0.1':
                $this->defaultDB = $this->localhost;
                break;
            case 'www.metalwingsweb.com':
            case 'metalwingsweb.com':
                $this->defaultDB = $this->producao;
                break;
        }
    }

    public function getDbConfig()
    {
        return $this->defaultDB;
    }

    /**
    * @return $appId (Facebook App Id)
    */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
    * @return $secretId (Facebook Secret Id)
    */
    public function getSecretId()
    {
        return $this->secretId;
    }
}
