<?php
namespace mktInstagram\Controller;

require __SITE_PATH . "/model/usuarios.php";

use mktInstagram\Model\Usuarios;
use Facebook\FacebookRedirectLoginHelper;

class IndexController extends BaseController
{
    public function index()
    {
        $usuario = new Usuarios();
        $usuario->isLogged(true, false);

        # Configurações Básicas
        $this->registry->template->title = "Home";
        $this->registry->template->css = array("index");
        $this->registry->template->js = array();

        if (isset($_POST['data']) && !empty($_POST['data'])) {
            $logar = $usuario->loginUsuario($_POST['data']);
            if (!empty($logar)) {
                if (!is_array($logar)) {
                    $logar = array($logar);
                }
                
                $this->registry->template->erros = $logar;
            }
        }

        # Facebook Login Helper
        $retornoUrl = __SITE_URL . '/retorno';
        $helper = new FacebookRedirectLoginHelper($retornoUrl);

        $loginUrl = $helper->getLoginUrl();

        # Enviamos a URL de login para a view
        $this->registry->template->loginUrl = $loginUrl;

        # Renderizamos a view
        $this->registry->template->show('index');
    }
}
