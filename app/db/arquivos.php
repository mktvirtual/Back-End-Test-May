<?php

class arquivos extends db{
    
    public function insertArquivo($dados){
        $sql = "insert into arquivos (endereco,descricao,users_id,created) values ('{$dados["arquivo"]}','{$dados["descricao"]}','{$dados["users_id"]}',CURRENT_TIMESTAMP)";
        return $this->fetch($sql);
    }
    public function getID($file){
        $sql = "select arquivo_id from arquivos where endereco = '{$file}';";
        $result = $this->fetch($sql);
        return $result[0]["arquivo_id"];
    }
    public function lastPosts($user = null){
        if($user==null){
            $sql = "select a.*, u.* from arquivos as a left join users as u on a.users_id = u.user_id order by a.created DESC limit 10;";
        }else{
            $sql = "select a.*, u.* from arquivos as a left join users as u on a.users_id = u.user_id where a.users_id={$user} order by a.created DESC limit 10;";
        }
        return $this->fetch($sql);
    }
    
    public function post($id){
        $sql = "select a.*, u.* from arquivos as a left join users as u on a.users_id = u.user_id where a.arquivo_id={$id} limit 1;";
        return $this->fetch($sql);
    }
    
    public function delete($id,$idProfile){
        $result = $this->post($id);
        $sql = "delete from arquivos where arquivo_id={$id} and users_id={$idProfile}";
        $this->fetch($sql);        
    }
}

?>
