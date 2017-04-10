<?php

namespace App\Model;

class User extends ModelBase  {

    public function exists($login, $email = '') {
        $select = \App\Database::connect()->prepare("SELECT * FROM user WHERE login='$login' OR email='$email'");
        $select->execute();
        if ($select->rowCount() > 0) {
            flash('error', 'Este login já existente. Por favor, verifique os dados e tente novamente.', 'Erro');
            return true;
        } else {
            return false;
        }
    }

    public function updateProfile($data) {
        $update = \App\Database::connect()->prepare("UPDATE user SET name=?, login=?, site=?, biografy=?, gender=? WHERE id=?");
        $update->bindParam(1, $data['name']);
        $update->bindParam(2, $data['login']);
        $update->bindParam(3, $data['site']);
        $update->bindParam(4, $data['biografy']);
        $update->bindParam(5, $data['gender']);
        $update->bindParam(6, $data['id']);
        if ($update->execute()) {
            $_SESSION['user']['name'] = $data['name'];
            $_SESSION['user']['login'] = $data['login'];
            $_SESSION['user']['site'] = $data['site'];
            $_SESSION['user']['biografy'] = $data['biografy'];
            $_SESSION['user']['gender'] = $data['gender'];

            flash('success', 'Dados atualizados com sucesso!', 'Sucesso', true);
        } else {
            flash('error', 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.', 'Erro', true);
        }
    }
    
    public function register($data) {
        try {
            $select = \App\Database::connect()->prepare("SELECT * FROM user WHERE login='{$data['login']}' OR email='{$data['email']}'");
            $select->execute();
            if ($select->rowCount() > 0) {
                flash('error', 'Login ou E-mail já existente. Por favor, verifique os dados e tente novamente.', 'Erro');
            } else {
                $insert = \App\Database::connect()->prepare('INSERT INTO user (name, login, email, password) VALUES (?,?,?,?)');
                $insert->bindParam(1, $data['name']);
                $insert->bindParam(2, $data['login']);
                $insert->bindParam(3, $data['email']);
                $insert->bindParam(4, md5($data['password'] . SALT));
                if ($insert->execute()) {
                    $user = self::getUser($data['login']);
                    unset($data['password']);
                    $_SESSION['user'] = $user;
                    $_SESSION['welcome'] = true;
                    redirect('/');
                } else {
                    flash('error', 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.', 'Erro');
                }
            }
        } catch (\PDOException $e) {
            flash('error', $e->getMessage(), 'Erro');
        }
    }
    
    public function login($data) {
        try {
            $data['password'] = md5($data['password'] . SALT);
            $select = \App\Database::connect()->prepare("SELECT * FROM user WHERE password='{$data['password']}' AND login='{$data['username']}' OR email='{$data['username']}'");
            $select->execute();
            if ($select->rowCount() > 0) {
                $result = $select->fetch(\PDO::FETCH_ASSOC);
                unset($result['password']);
                $_SESSION['user'] = $result;
                redirect('/');
            } else {
                flash('error', 'Verifique os dados e tente novamente.', 'Login inválido');
            }
        } catch (\PDOException $e) {
            flash('error', $e->getMessage(), 'Erro');
        }
    }
    
    public function getUser($username) {
        try {
            $select = \App\Database::connect()->prepare("SELECT * FROM user WHERE login='{$username}'");
            $select->execute();
            $result = $select->fetch(\PDO::FETCH_ASSOC);
            unset($result['password']);
            return $result;
        } catch (\PDOException $e) {
            flash('error', $e->getMessage(), 'Erro');
        }
    }
    
    public function updateLikes($likeStr, $uid) {
        $update = \App\Database::connect()->prepare("UPDATE user SET likes='$likeStr' WHERE id=$uid");
        $update->execute();
    }

    public function totalPosts($uid) {
        try {
            $select = \App\Database::connect()->prepare("SELECT COUNT(*) FROM post WHERE user_id=$uid");
            $select->execute();
            return $select->fetch()[0];
        } catch (\PDOException $e) {
            flash('error', $e->getMessage(), 'Erro');
        }
    }

    public function getPosts($uid) {
        try {
            $select = \App\Database::connect()->prepare("SELECT * FROM post WHERE user_id={$uid} ORDER BY created_at DESC");
            $select->execute();
            $result = $select->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            flash('error', $e->getMessage(), 'Erro');
        }
    }

}