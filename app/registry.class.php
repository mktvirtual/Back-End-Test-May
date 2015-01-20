<?php
namespace mktInstagram;

class Registry
{
    private $vars = array();

    /*
    * @ set undefined variables
    */

    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    /*
    * @ get variables
    */

    public function __get($index)
    {
        return $this->vars[$index];
    }
}
