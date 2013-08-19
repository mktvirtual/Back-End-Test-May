<?php

class users extends db{
    
    public function addUser($data){
        $sql = "insert into users (user_id,nome,email,username) values ({$data["id"]},'{$data["name"]}','{$data["email"]}','{$data["username"]}');";        
        if($this->fetch($sql)){
            return true;
        }else{
            return false;
        }
    }
    
    public function deleteUser($id){
        $sqlDelUser = "delete from users where id='{$id}';";
        if($this->fetch($sqlDelUser)){
            return true;
        }else{
            return false;
        }
    }
    
    public function hasUser($id){
        $query = "select count(*) from users where id={$id}";
        $count = $this->fetch($sql);
        if($count["count(*)"] > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function getProfile($id){
        $sql = "select * from users where user_id={$id};";
        return $this->fetch($sql);
    }
}
?>
