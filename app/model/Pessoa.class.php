<?php

class Pessoa {

    public function __construct() {
        $postModel = new PostModel();
        $assinaturasModel = new AssinaturasModel();
        $postModel->_class = false;

        $posts = $postModel->read(array(
            'fields' => "COUNT(`id`) as `count`",
            'where' => "`autor` = {$this->id}",
            'limit' => '12'
        ));

        $seguidores = $assinaturasModel->read(array(
            'fields' => "COUNT(`lider`) as `count`",
            'where' => "`lider` = {$this->id}"
        ));

        $seguindo = $assinaturasModel->read(array(
            'fields' => "COUNT(`seguidor`) as `count`",
            'where' => "`seguidor` = {$this->id}"
        ));

        $this->publicacoes = $posts->count;
        $this->seguidores = $seguidores->count;
        $this->seguindo = $seguindo->count;
    }

    public function load_tree_posts() {
        $postModel = new PostModel;

        $this->posts = $postModel->read(array(
            'where' => "`autor` = {$this->id}",
            'limit' => '3',
            'order' => "`data` DESC"
        ),true);
    }

}
