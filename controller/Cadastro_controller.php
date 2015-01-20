<?php
namespace mktInstagram\Controller;

require __SITE_PATH . "/model/usuarios.php";

use mktInstagram\Model\Usuarios;

class CadastroController extends BaseController
{
    public function index()
    {
        # Configurações Básicas
        $this->registry->template->title = "Novo Cadastro";
        $this->registry->template->css = array("fonts", "global", "internas", "forms");
        $this->registry->template->js = array();

        # Cadastrar novo usuário
        if (isset($_POST['data']) && !empty($_POST['data'])) {
            $usuario = new Usuarios();
            $cadastro = $usuario->cadastrarUsuario($_POST['data'], @$_FILES);

            if (!empty($cadastro["erros"])) {
                $this->registry->template->erros = $cadastro["erros"];
            }
        }

        # Renderizamos a view
        $this->registry->template->show('cadastro');
    }

    public function sair()
    {
        Usuarios::sair();
    }
}
