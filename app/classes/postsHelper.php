<?php

class postsHelper {

    public function toHtml($data) {
        if (count($data) > 0) {
            foreach ($data as $post) {
                $return .= "<div class='post container_12'>";
                $return .= "<div class='grid_12'>";
                $return .= "<p>";
                $return .= "<a href='/user/profile/{$post['users_id']}'><img class='fotoPost' src='https://graph.facebook.com/{$post['username']}/picture' align='left'/></a>";
                $return .= "<p>";
                $return .= "<b>{$post['nome']} em " . date('d/m/Y - H:i:s', strtotime($post['created'])) . "</b>";
                $return .= "<b>{$post['comentario']}</b>";
                $return .= "</p>";
                $return .= "</p>";
                $return .= "</div>";
                $return .= "<div class='foto grid_6'>";
                $return .= "<a href='/user/photo/{$post["arquivo_id"]}'><img class='fotoPost' src='/usersFiles/{$post['endereco']}' /></a>";
                $return .= "</div>";
                $return .= "<div class='dadosFoto grid_6'>";
                $return .= "<div class='comentarios'>";
                $return .= $this->comments($post["arquivo_id"],5);
                $return .= "<form class='formee comentario' action='/user/comentario/{$post["arquivo_id"]}' method='POST'>";
                $return .= "<div class='grid_9'>                 ";
                $return .= "<input type='text' name='comentario' placeholder='Escreva seu Comentário'/>";
                $return .= "</div>";
                $return .= "<div class='grid_3'>";
                $return .= "<input type='submit' value='GO!' class='formee-button' />";
                $return .= "</div>";
                $return .= "</form>";
                $return .= "</div>";
                $return .= "</div>";
                $return .= "<br clear = 'all'/>";
                $return .= "</div>";
            }
        } else {
            $return .= "<div class='post container_12'>";
            $return .= "<h2>Nenhuma postagem encontrada</h2>";
            $return .= "</div>";
        }
        return $return;
    }

    public function comments($id, $limit) {

        include_once ROOT . "/app/db/comentarios.php";
        $comentarios = new comentarios;
        $data = $comentarios->comments($id, $limit);
        if (count($data) > 0) {
            foreach ($data as $comment) {
                $return .= "<div class='container_12'>";
                $return .= "<br/>";
                $return .= "<div class='grid_12'>";
                $return .= "<img class='fotoPost' src='https://graph.facebook.com/{$comment['username']}/picture' align='left'/>";
                $return .= "<p><b>{$comment["nome"]}</b> em " . date('d/m/Y - H:i:s', strtotime($comment['created'])) . "</p>";
                $return .= "<p>{$comment["comentario"]}</p>";
                $return .= "</div>";
                $return .= "</div>";
            }
        } else {
            $return .= "<br/><br/><center><h2>Nenhum Comentário</h2></center>";
        }

        return $return;
    }

    public function unique($data) {
        if (count($data) > 0) {
            foreach ($data as $post) {
                $return .= "<div class='post container_12'>";
                $return .= "<div class='grid_12'>";
                $return .= "<p>";
                $return .= "<a href='/user/profile/{$post['users_id']}'><img class='fotoPost' src='https://graph.facebook.com/{$post['username']}/picture' align='left'/></a>";
                $return .= "<p>";
                $return .= "<b>{$post['nome']} em " . date('d/m/Y - H:i:s', strtotime($post['created'])) . "</b>";
                $return .= "<b>{$post['comentario']}</b>";
                $return .= "</p>";
                $return .= "</p>";
                $return .= "</div>";
                $return .= "<div class='foto grid_12'>";
                $return .= "<center><img class='fotoPost' src='/usersFiles/{$post['endereco']}' /></center>";
                $return .= "</div>";
                $return .= "<div class='dadosFoto grid_6'>";
                $return .= "</div>";
                $return .= "<br clear = 'all'/>";
                $return .= "</div>";

                $return .= "<div class='comentarios post container_12'>";
                $return .= $this->comments($post["arquivo_id"], 20);
                $return .= "<form class='formee comentario' action='/user/comentario/{$post["arquivo_id"]}' method='POST'>";
                $return .= "<div class='grid_9'>";
                $return .= "<input type='text' name='comentario' placeholder='Escreva seu Comentário'/>";
                $return .= "</div>";
                $return .= "<div class='grid_3'>";
                $return .= "<input type='submit' value='GO!' class='formee-button' />";
                $return .= "</div>";
                $return .= "</form>";
                $return .= "</div>";
            }
        } else {
            $return .= "<div class='post container_12'>";
            $return .= "<h2>Nenhuma postagem encontrada</h2>";
            $return .= "</div>";
        }
        return $return;
    }

    public function formPost() {
        $return .= "<div class='post container_12'>";
        $return .= "<form class='formee' action='/user/panel' method='POST' enctype='multipart/form-data'>";
        $return .= "<div class='grid-12-12'>";
        $return .= "<input type='text' name='descricao' placeholder='Digite uma Descrição (Opcional)' />";
        $return .= "</div>";
        $return .= "<div class='grid-10-12'>";
        $return .= "<input type='file' name='arquivo' placeholder='Selecione um arquivo'/>";
        $return .= "</div>";
        $return .= "<div class='grid-2-12'><input type='submit' value='Enviar'/></div>";
        $return .= "</form>";
        $return .= "</div>";
        return $return;
    }

}

?>
