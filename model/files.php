<?php
namespace mktInstagram\Model;

class Files
{
    public static function criarPasta($path)
    {
        if (!file_exists($path)) {
            $dirname = dirname($path);
            if (!file_exists($dirname)) {
                self::criarPasta($dirname);
            }

            @mkdir($path);
            if (!file_exists($path)) {
                @chmod($dirname, 0777);
                @mkdir($path);
                @chmod($path, 0777);
            }
        }
    }
}
