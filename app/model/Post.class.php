<?php

class Post {
    
    public function __construct() {
        $usuarioModel = new UsuarioModel();
        $curtidasModel = new CurtidasModel();
        $comentariosModel = new ComentariosModel();
        
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $this->data);
        
        $this->autor = $usuarioModel->read(array('where'=>"`id` = {$this->autor}"));
        $this->data = $dateTime->format('d/m/Y');
        $this->curtidas = $curtidasModel->read(array('where' => "`post` = {$this->id}"));
        $this->comentarios = $comentariosModel->read(array('where' => "`post` = {$this->id}"));        
        $this->curtidas_count = ($this->curtidas)?count($this->curtidas):0;
        $this->comentarios_count = ($this->comentarios)?count($this->comentarios):0;
    }
    
}
