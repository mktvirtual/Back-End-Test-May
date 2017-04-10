<?php

namespace App\Model;

class Post extends ModelBase  {

    public function getAll() {
        try {
            $select = \App\Database::connect()->prepare("SELECT p.id, p.user_id, p.img_path, p.description, p.likes, p.created_at, u.login, u.name, u.avatar FROM post p INNER JOIN user u ON p.user_id = u.id ORDER BY p.created_at DESC");
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            flash('error', $e->getMessage(), 'Erro');
        }
    }

    public function getPost($postId) {
        try {
            $select = \App\Database::connect()->prepare("SELECT p.id, p.user_id, p.img_path, p.description, p.likes, p.created_at, u.login, u.name, u.avatar FROM post p INNER JOIN user u ON p.user_id = u.id WHERE p.id={$postId}");
            $select->execute();
            return $select->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            flash('error', $e->getMessage(), 'Erro');
        }
    }

    public function increaseLike($id) {
        $update = \App\Database::connect()->prepare("UPDATE post SET likes=likes+1 WHERE id=$id");
        $update->execute();
    }

    public function decreaseLike($id) {
        $update = \App\Database::connect()->prepare("UPDATE post SET likes=likes-1 WHERE id=$id");
        $update->execute();
    }

}