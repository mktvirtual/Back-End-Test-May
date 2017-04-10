<?php

namespace App\Controller;

use App\Model;
use App\View;

class IndexController extends ControllerBase {

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $regiter = \App\Model\User::register($_POST);
            $this->view('index/index');
        } else {
            if (isset($_SESSION['user'])) {
                $this->isAuth();
                $posts = \App\Model\Post::getAll();
                $this->view('user/index', ['user' => $_SESSION['user'], 'posts' => $posts]);
            } else {
                $this->view('index/index');
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $regiter = \App\Model\User::login($_POST);
        } else {
            if (isset($_SESSION['user'])) {
                redirect('/');
            }
        }
        $this->view('index/login');
    }

    public function logout() {
        session_destroy();
        unset($_SESSION['user']);
        redirect('/login');
    }

    public function uploadAvatar() {
        if (isset($_FILES['avatar']['type'])) {
            $validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            $validExtensions = ['jpeg', 'jpg', 'png'];
            $explode = explode('.', $_FILES['avatar']['name']);
            $fileExtension = end($explode);

            if (
                $_FILES['avatar']['size'] < 2000000 /*2Mb*/ &&
                in_array($fileExtension, $validExtensions) &&
                in_array($_FILES['avatar']['type'], $validTypes)
            ) {
                if ($_FILES['avatar']['error'] > 0) {
                    echo json_encode(['error' => true, 'message' => $_FILES['avatar']['error']]);
                } else {
                    $name = uniqid('a_') . '.jpg';
                    $sourcePath = $_FILES['avatar']['tmp_name'];
                    $targetPath = __DIR__ . '/../../public/uploads/avatar/' . $name;
                    $relativePath = '/public' . explode('/public', $targetPath)[1];

                    switch ($fileExtension) {
                        case 'jpg':
                        case 'jpeg':
                            $src = imagecreatefromjpeg($sourcePath);
                            break;
                        
                        case 'png':
                            $src = imagecreatefrompng($sourcePath);
                            break;

                        default: 
                            $src = imagecreatefromjpeg($sourcePath);
                            break;
                    }

                    list($w, $h) = getimagesize($sourcePath);
                    $width = $height = 250;
                    if ($w > $h) {
                        $newHeight = $height;
                        $newWidth = floor($w * ($newHeight / $h));
                        $cropX = ceil(($w - $h) / 2);
                        $cropY = 0;
                    } else {
                        $newWidth = $width;
                        $newHeight = floor($h * ($newWidth / $w));
                        $cropX = 0;
                        $cropY = ceil(($h - $w) / 2);
                    }

                    $tmp = imagecreatetruecolor($width, $height);
                    $whiteBg = imagecolorallocate($tmp, 255, 255, 255);
                    imagefill($tmp, 0, 0, $whiteBg);
                    imagecopyresampled($tmp, $src, 0, 0, $cropX, $cropY, $newWidth, $newHeight, $w, $h);
                    imagejpeg($tmp, $targetPath, 75);

                    $update = \App\Database::connect()->prepare("UPDATE user SET avatar='$relativePath' WHERE id='{$_SESSION['user']['id']}'");
                    if ($update->execute()) {
                        $_SESSION['user']['avatar'] = $relativePath;
                        echo json_encode(['error' => false, 'message' => 'Imagem enviada com sucesso!', 'path' => $relativePath]);
                    } else {
                        echo json_encode(['error' => true, 'message' => 'Não foi possível gravar a alteração no banco de dados. Por favor, tente novamente mais tarde.']);
                    }

                    /*if (move_uploaded_file($sourcePath, $targetPath)) {
                        echo json_encode(['error' => false, 'message' => 'Imagem enviada com sucesso!']);
                    } else {
                        echo json_encode(['error' => true, 'message' => 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.']);
                    }*/
                }
            } else {
                echo json_encode(['error' => true, 'message' => 'Imagem inválida.']);
            }
        }
    }

    public function uploadPost() {
        if (isset($_FILES['post']['type'])) {
            $validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            $validExtensions = ['jpeg', 'jpg', 'png'];
            $explode = explode('.', $_FILES['post']['name']);
            $fileExtension = end($explode);

            if (
                $_FILES['post']['size'] < 5000000 /*5Mb*/ &&
                in_array($fileExtension, $validExtensions) &&
                in_array($_FILES['post']['type'], $validTypes)
            ) {
                if ($_FILES['post']['error'] > 0) {
                    echo json_encode(['error' => true, 'message' => $_FILES['post']['error']]);
                } else {
                    $name = uniqid('p_') . '.jpg';
                    $sourcePath = $_FILES['post']['tmp_name'];
                    $targetPath = __DIR__ . '/../../public/uploads/post/' . $name;
                    $relativePath = '/public' . explode('/public', $targetPath)[1];

                    switch ($fileExtension) {
                        case 'jpg':
                        case 'jpeg':
                            $src = imagecreatefromjpeg($sourcePath);
                            break;
                        
                        case 'png':
                            $src = imagecreatefrompng($sourcePath);
                            break;

                        default: 
                            $src = imagecreatefromjpeg($sourcePath);
                            break;
                    }

                    list($w, $h) = getimagesize($sourcePath);
                    $width = $height = 600;
                    if ($w > $h) {
                        $newHeight = $height;
                        $newWidth = floor($w * ($newHeight / $h));
                        $cropX = ceil(($w - $h) / 2);
                        $cropY = 0;
                    } else {
                        $newWidth = $width;
                        $newHeight = floor($h * ($newWidth / $w));
                        $cropX = 0;
                        $cropY = ceil(($h - $w) / 2);
                    }

                    $tmp = imagecreatetruecolor($width, $height);
                    $whiteBg = imagecolorallocate($tmp, 255, 255, 255);
                    imagefill($tmp, 0, 0, $whiteBg);
                    imagecopyresampled($tmp, $src, 0, 0, $cropX, $cropY, $newWidth, $newHeight, $w, $h);
                    imagejpeg($tmp, $targetPath, 100);

                    $created = date('Y-m-d H:i:s');
                    $insert = \App\Database::connect()->prepare("INSERT INTO post (user_id, img_path, likes, created_at, description) VALUES({$_SESSION['user']['id']}, '{$relativePath}', 0, '$created', '')");
                    if ($insert->execute()) {
                        echo json_encode(['error' => false, 'message' => 'Imagem enviada com sucesso!', 'path' => $relativePath]);
                    } else {
                        echo json_encode(['error' => true, 'message' => 'Não foi possível gravar a alteração no banco de dados. Por favor, tente novamente mais tarde.']);
                    }
                }
            } else {
                echo json_encode(['error' => true, 'message' => 'Imagem inválida.']);
            }
        }
    }

    public function removeAvatar() {
        $update = \App\Database::connect()->prepare("UPDATE user SET avatar=NULL WHERE id='{$_SESSION['user']['id']}'");
        if ($update->execute()) {
            unlink(__DIR__ . '/../..' . $_SESSION['user']['avatar']);
            $_SESSION['user']['avatar'] = null;
        }
    }

    public function removePost() {
        if ($_SESSION['user']['id'] == $_POST['uid']) {
            $id = $_POST['p'];
            $imgSrc = $_POST['s'];
            $delete = \App\Database::connect()->prepare("DELETE FROM post WHERE id=$id");
            if ($delete->execute()) {
                echo json_encode(['error' => false]);
                unlink(__DIR__ . '/../..' . $imgSrc);
            } else {
                echo json_encode(['error' => true]);
            }
        }
    }

    public function like() {
        $p = $_POST['p'];
        $likes = empty($_SESSION['user']['likes']) ? [] : explode(';', $_SESSION['user']['likes']);
        if (count($likes) > 0) unset($likes[count($likes) - 1]);

        $add = true;
        foreach ($likes as $key => $val) {
            if ($p == $val) {
                unset($likes[$key]);
                $add = false;
                break;
            }
        }

        if ($add) {
            array_push($likes, $p);
            \App\Model\Post::increaseLike($p);
        } else {
            \App\Model\Post::decreaseLike($p);
        }

        $_SESSION['user']['likes'] = implode(';', $likes) . ';';
        \App\Model\User::updateLikes($_SESSION['user']['likes'], $_SESSION['user']['id']);
    }

    public function unsetFlash() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            unset($_SESSION['flashMsg']);
        } else {
            $this->view('error/404');
        }
    }

}