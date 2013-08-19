<?php

class comentarios extends db{
    public function insert($data){
        $sql = "insert into comentarios (user_id,arquivo_id,comentario,created) values ({$data["user_id"]},{$data["arquivo_id"]},'{$data["comentario"]}', CURRENT_TIMESTAMP)"; 
        return $this->fetch($sql);
    }
    
    public function comments($id, $limit){
        $sql = "select c.*, u.* from comentarios as c left join users as u on c.user_id=u.user_id order by c.created limit {$limit};";
        return $this->fetch($sql);
    }
    
    public function deletar($id){
        
    }
}

?>
