<?php
class home extends core{
    
    public function index(){
      $this->setVar("posts",$this->arquivos->lastPosts());
    }
    
    public function cadastro(){
        
    }
}
?>