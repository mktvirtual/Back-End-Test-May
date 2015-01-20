<?php
namespace mktInstagram\Controller;

require __SITE_PATH . "/model/usuarios.php";

use mktInstagram\Model\Usuarios;
use mktInstagram\Model\Files;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use mktInstagram\Vendor\Resize;

class MinhaContaController extends BaseController
{
    public function index()
    {
        $usuario = new Usuarios();
        $usuario->isLogged(false, true);

        # Configurações Básicas
        $this->registry->template->title = "Minha Conta";
        $this->registry->template->css = array("internas", "lightbox/lightbox");
        $this->registry->template->js = array("lightbox/lightbox.min");

        # Buscamos as informações do usuário logado
        if (isset($_SESSION['user_id'])) {
            $conteudo = $usuario->buscaUsuario($_SESSION['user_id']);
            $this->registry->template->usuario = $conteudo["dados"][0];
            $nomeUsuario = $conteudo["dados"][0]["vc_nome_usuario"];
            $this->registry->template->nomeUsuario = $nomeUsuario;

            # Procuramos a foto de perfil do usuário
            $profilePhoto = glob(__SITE_PATH . "/assets/datafiles/{$_SESSION['user_id']}/profile.*");

            if (!isset($profilePhoto[0])) {
                $profilePhoto = __SITE_PATH . "/assets/images/perfil-padrao.jpg";
            } else {
                $profilePhoto = $profilePhoto[0];
            }

            $this->registry->template->profile_pic = str_replace(__SITE_PATH, __SITE_URL, $profilePhoto);

            # Procuramos todas as fotos na medida 300x300 do usuário
            $fotos = $usuario->buscaFotos("300x300");
            $this->registry->template->fotosUser = $fotos["dados"];
            $this->registry->template->nrPublicacoes = $fotos["count"];
        }

        # Renderizamos a view
        $this->registry->template->show('minha-conta');
    }

    public function alterar()
    {
        $usuario = new Usuarios();
        $usuario->isLogged(false, true);

        # Configurações Básicas
        $this->registry->template->title = "Alterar Perfil";
        $this->registry->template->css = array("internas", "forms");
        $this->registry->template->js = array();

        if (!empty($_POST['data'])) {
            $alterar = $usuario->alterarCadastro($_POST['data'], @$_FILES);

            $this->registry->template->erros = $alterar["erros"];
            $this->registry->template->ok = $alterar["ok"];
        }

        if (isset($_SESSION['user_id'])) {
            $conteudo = $usuario->buscaUsuario($_SESSION['user_id']);
            $this->registry->template->usuario = $conteudo["dados"][0];
        }

        # Procuramos pelo usuário
        $meuUsuario = $usuario->buscaUsuario($_SESSION['user_id']);
        $nomeUsuario = $meuUsuario["dados"][0]["vc_nome_usuario"];
        $this->registry->template->nomeUsuario = $nomeUsuario;

        # Renderizamos a view
        $this->registry->template->show('alterar-cadastro');
    }

    public function enviaFoto()
    {
        $usuario = new Usuarios();
        $usuario->isLogged(false, true);

        # Configurações Básicas
        $this->registry->template->title = "Nova Foto";
        $this->registry->template->css = array("jCrop/jquery.Jcrop", "internas", "forms");
        $this->registry->template->js = array("jCrop/jquery.Jcrop.min");

        $tempPath = __SITE_PATH . "/assets/datafiles/{$_SESSION['user_id']}/temp";
        Files::criarPasta($tempPath);

        if (isset($_FILES) && !empty($_FILES['data']['name'])) {
            $tempFile = $_FILES['data'];

            $tmp_name = $tempFile["tmp_name"]["foto"];
            list($width, $height) = getimagesize($tmp_name);

            $extensoesAceitas = array("image/jpg", "image/jpeg", "image/png");
            $mimetype = $tempFile["type"]["foto"];

            $ext = explode("/", $mimetype);
            $ext = end($ext);

            if (in_array($mimetype, $extensoesAceitas)) {
                $nomeArquivo = __SITE_URL."/assets/datafiles/{$_SESSION['user_id']}/temp/chamada.{$ext}";

                # Verificamos se já existe alguma foto de perfil e excluímos
                $verificarGlob = glob($tempPath."/*");
                if (isset($verificarGlob[0])) {
                    foreach ($verificarGlob as $item) {
                        unlink($item);
                    }
                }

                move_uploaded_file($tempFile["tmp_name"]["foto"], "{$tempPath}/chamada.{$ext}");
                $this->registry->template->tempFile = $nomeArquivo;
            } else {
                header("Location: " . __SITE_URL . "/minha-conta");
            }

            # Redimensionamos a foto temporária para redimensioná-la pelo jCrop.js
            $resizeTemp = new Resize($nomeArquivo);
            $resizeTemp->resizeImage(600, 500, "portrait");
            $resizeTemp->saveImage("{$tempPath}/chamada.{$ext}", 80);
            $resizeTemp->destroyImage();
        }

        # Procuramos pelo usuário
        $meuUsuario = $usuario->buscaUsuario($_SESSION['user_id']);
        $nomeUsuario = $meuUsuario["dados"][0]["vc_nome_usuario"];
        $this->registry->template->nomeUsuario = $nomeUsuario;

        $this->registry->template->show('envia-foto');
    }
}
