<?php
namespace mktInstagram\Controller;

require __SITE_PATH . "/model/usuarios.php";

use mktInstagram\Model\Usuarios;
use mktInstagram\DB;
use mktInstagram\Vendor\Resize;

class RetornoController extends BaseController
{
    public function index()
    {
        $usuario = new Usuarios();
        $helper = $this->registry->facebookHelper;

        $session = null;

        try {
            $session = $helper->getSessionFromRedirect();
        } catch (FacebookRequestException $ex) {
            var_dump('Fb Exception => ' . $ex);
        } catch (\Exception $ex) {
            var_dump('Common Exception => ' . $ex);
        }

        if ($session) {
            $accessToken = $session->getAccessToken();
            $extendedAccessToken = $accessToken->extend();

            $_SESSION['fbAccessToken'] = (string) $extendedAccessToken;
            $usuario->loginUsuarioFacebook();
        }
    }

    public function enviaFoto()
    {
        $novaFoto = new Resize($_POST['file']);
        $savePath = __SITE_PATH . "/assets/datafiles/{$_SESSION['user_id']}";
        $finalName = $novaFoto->saveNewFileOnDatabase($_SESSION['user_id'], $_POST['legenda']);

        $savedPhoto = $novaFoto->saveCroppedImage($savePath, 100, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], $finalName);
        $novaFoto->destroyImage();

        $finalSave = $novaFoto->saveOtherSizes($savedPhoto);

        if ($finalSave == true) {
            header("Location: " . __SITE_URL . "/minha-conta");
        }
    }
}
