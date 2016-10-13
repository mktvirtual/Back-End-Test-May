<?php

require_once HELPERS . 'ImageResize.php';
use \Eventviva\ImageResize;

class PostController extends Controller {

    public function add() {
        global $usuario;

        $tempname = $_FILES['foto']['tmp_name'];
        $filename = UPLOADS . $_FILES['foto']['name'];

        if ($_FILES['foto']['type'] !== 'image/gif'):
            $image = new ImageResize($tempname);
            $image->resizeToWidth(WIDTH_TO_RESIZE);
            $image->save($filename);
        else:
            move_uploaded_file($tempname, $filename);
        endif;

        $dados = array(
            'autor' => $usuario->getID(),
            'foto' => $filename,
            'data' => date('Y-m-d H:i:s'),
            'descricao' => $_POST['descricao']
        );

        $postModel = new PostModel();
        $postModel->insert($dados);

        header('Location: '. make_url('usuario/perfil'));
    }

    public function page() {
        global $usuario;
        $postID = isset($_GET['p'])?$_GET['p']:false;
        $vars = array();
        
        $postModel = new PostModel();
        $post = $postModel->read(array('where'=>"`id`={$postID}"));
        
        if(!$post)
            return false;
        
        $vars['post'] = $post;
        $vars['current_user'] = ($post->autor->id == $usuario->getID());
        
        $this->view('post', $vars);
    }
}
