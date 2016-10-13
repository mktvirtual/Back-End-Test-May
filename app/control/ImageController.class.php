<?php

require_once HELPERS . 'ImageResize.php';

use \Eventviva\ImageResize;

class ImageController {

    public function thumb() {
        $file = $_GET['f'];
        
        $image = new ImageResize($file);
        $image->crop(350, 350);
        $image->output();
    }

}
