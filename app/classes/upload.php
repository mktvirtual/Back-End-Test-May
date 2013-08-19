<?php

class upload{

    public $allow = array(
        "jpg",
        "png",
        "jpeg"
    );
    public $maxSize = 4;

    public function uploadFile($file = array(), $path = null, $name = null) {

        $path = is_null($path) ? $this->path : $path;
        $name = is_null($name) ? $this->fileName() : $name;

        if ($this->valida($file)):
            if (!is_dir($path)):
                mkdir($path, 0777, true);
            endif;
            $fileName = $path . "/" . $name.".".$this->getExt($file["name"]);
            if (move_uploaded_file($file["tmp_name"], $fileName)):
                require_once 'resize-class.php';
                $redimensionador = new resize($fileName);
                $redimensionador->resizeImage(300, 300, "auto");
                $redimensionador->saveImage($fileName,100);
                return $name.".".$this->getExt($file["name"]);
            else:
                return false;
            endif;
        else:
            return false;
        endif;
    }
    
    public function valida($file = array()) {
        if(empty($file) && !isset($file["name"])):
            return false;
            
        endif;
        if($file["size"] > $this->maxSize * 1024 * 1024):
            return false;
        endif;
        if(!empty($this->allow) && !in_array($this->getExt($file["name"]), $this->allow)):
            return false;
        endif;
        return true;
    }

    public function getExt($file = "") {
        return strtolower(trim(substr($file, strrpos($file, ".") + 1, strlen($file))));
    }
    
    public function fileName($tamanho=36) {
        $CaracteresAceitos = 'ABCDEF0123456789';
        $max = strlen($CaracteresAceitos) - 1;
        for ($i = 0; $i < $tamanho; $i++) {
            $retorno .= $CaracteresAceitos{mt_rand(0, $max)};
        }
        return $retorno;
    }
    
    public function resize($fileName){
        require_once "m2brimagem.class.php";
        $mb = new m2brimagem();
    }

}

?>