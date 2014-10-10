<?php
namespace Skp;

class Registry
{

    protected static $data = [];

    public static function set($name, $value)
    {
        self::$data[$name] = $value;
    }

    public static function get($name, $default = null)
    {
        return (isset(self::$data[$name])) ? self::$data[$name] : $default;
    }

} 