<?php

namespace App\Controller;

use App\View;

class UserController extends ControllerBase {

    public function profile($user) {
        $this->isAuth();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($user['login'] != $_POST['login']) {
                if (!\App\Model\User::exists($_POST['login'])) {
                    \App\Model\User::updateProfile($_POST);
                    redirect("/{$_POST['login']}");
                }
            } else {
                \App\Model\User::updateProfile($_POST);
                redirect("/{$_POST['login']}");
            }
        }

        $posts = \App\Model\User::getPosts($user['id']);
        $this->view('user/profile', compact('user', 'posts'));
    }

    public function post($postId) {
        $this->isAuth();
        $post = \App\Model\Post::getPost($postId);
        $this->view('user/post', compact('post'));
    }

}