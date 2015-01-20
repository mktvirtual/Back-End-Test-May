<?php
namespace mktInstagram\Model;

require "usuarios_interface.php";

use mktInstagram\DB;
use mktInstagram\Model\Files;
use mktInstagram\Vendor\Resize;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class Usuarios extends DB implements UsuariosInterface
{
    private $id;
    private $fb_id;
    private $fb_token;
    private $connection;
    private $model = 'usuarios';
    private $validate = array('vc_nome', 'vc_email', 'vc_nome_usuario', 'vc_senha');

    public function __construct()
    {
        $this->connection = new DB();
    }

    /**
    * Método responsável por salvar ou logar o usuário na aplicação
    */
    public function loginUsuarioFacebook()
    {
        if (empty($this->fb_token)) {
            $this->setFbToken($_SESSION['fbAccessToken']);
        }

        # Facebook Session
        $session = new FacebookSession($this->fb_token);

        $user_profile = new FacebookRequest($session, 'GET', '/me');
        $profile = $user_profile->execute()->getGraphObject(GraphUser::className());
        $fbId = $profile->getId();

        # Se ele já estiver cadastrado com a conta do Facebook, logamos
        $busca = $this->connection->find($this->model, array("{$this->model}.fb_id" => $fbId));

        if ($busca["count"] > 0) {
            $_SESSION['user_id'] = $busca["dados"][0]["id"];
            setcookie('accessToken', $this->fb_token, time()+(60*60*24*2), '/');

            $this->salvarUltimoAcesso($_SESSION['user_id']);
            $this->connection->desconectar();

            header("Location: " . __SITE_URL . "/minha-conta");
        }

        # Se não estiver cadastrado, pegamos mais informações para cadastrá-lo
        $nome = $profile->getName();
        $email = $profile->getEmail();
        $nome_usuario = $this->gerarNomeUsuario($this->model, 'vc_nome_usuario', $profile->getFirstName());
        $data = date('Y-m-d H:i:s');
        
        $columns = array(
            "fb_id",
            "fb_token",
            "vc_nome",
            "vc_nome_usuario",
            "vc_email",
            "dt_cadastro",
            "dt_ultimo_acesso"
        );

        $items = array(
            $fbId,
            $this->fb_token,
            $nome,
            $nome_usuario,
            $email,
            $data,
            $data
        );

        $salvar = $this->connection->saveOrUpdate("usuarios", $columns, $items);
        $lastId = $this->connection->lastInsertId();

        # Salvamos a foto automaticamente (200x200)
        $profilePath = __SITE_PATH . "/assets/datafiles/{$lastId}";
        Files::criarPasta($profilePath);

        copy("https://graph.facebook.com/{$fbId}/picture?type=large", $profilePath . "/profile.jpg");

        $_SESSION['user_id'] = $lastId;
        setcookie('accessToken', $this->fb_token, time()+(60*60*24*2), '/');

        header("Location: " . __SITE_URL . "/minha-conta");
    }

    /**
    * Método responsável logar um usuário normal
    */
    public function loginUsuario($data)
    {
        $retorno["erros"] = $this->validar($data);

        if (empty($retorno['erros'])) {
            $data['vc_senha'] = $this->encriptaSenha($data['vc_senha']);

            # Se ele já estiver cadastrado com a conta do Facebook, logamos
            $busca = $this->connection->find($this->model, $data);

            if ($busca["count"] > 0) {
                $_SESSION['user_id'] = $busca["dados"][0]["id"];
                $this->salvarUltimoAcesso($_SESSION['user_id']);
                $this->connection->desconectar();

                header("Location: " . __SITE_URL . "/minha-conta");
            } else {
                $retorno["erros"] = "Usuário ou senhas incorretos!";
            }
        }

        return $retorno["erros"];
    }

    /**
    * Método responsável por buscar os dados do cliente
    * @param int $id : ID do usuário
    */
    public function buscaUsuario($id)
    {
        return $this->connection->findById($this->model, $id);
    }

    /**
    * Método responsável por buscar as fotos do usuário de acordo com as dimensões
    * @param string $dimensoes : Nome da pasta
    * @param int $limite : Limite de fotos a serem retornadas
    * @param int $pagina : Página, caso seja utilizado paginação
    * @return array
    */
    public function buscaFotos($dimensoes, $limite = null, $pagina = null)
    {
        $conditions = array("files.usuario_id" => $_SESSION['user_id']);
        $busca = $this->connection->find("files", $conditions);

        $fotos["dados"] = array();
        if (!empty($busca)) {
            $pos = 0;
            foreach ($busca["dados"] as $item) {
                $itemId = str_pad($item['id'], 2, "0", STR_PAD_LEFT);
                $arquivo = glob(__SITE_PATH . "/assets/datafiles/{$_SESSION['user_id']}/$dimensoes/{$itemId}.*");
                if (isset($arquivo[0])) {
                    $fotos["dados"][$pos]["url"] = str_replace(__SITE_PATH, __SITE_URL, $arquivo[0]);
                    $fotos["dados"][$pos]["legenda"] = $item["vc_legenda"];

                    $ext = strrchr($fotos["dados"][$pos]["url"], ".");
                    $fotos["dados"][$pos]["url_grande"] = __SITE_URL . "/assets/datafiles/{$_SESSION['user_id']}/500x500/{$itemId}{$ext}";

                    $pos++;
                }
            }

            $fotos["count"] = $busca["count"];
        }        

        return $fotos;
    }

    /**
    * Método responsável por cadastrar um usuário normal
    * @param $data | type: array
    */
    public function cadastrarUsuario($data, $file = null)
    {
        $retorno["erros"] = $this->validar($data, array());

        if ($this->nomeUsuarioExiste($data['vc_nome_usuario'])) {
            $retorno["erros"] = array_merge($retorno["erros"], array("Nome de usuário já está sendo usado."));
        }

        if ($this->emailExiste($data['vc_email'])) {
            $retorno["erros"] = array_merge($retorno["erros"], array("Este e-mail já está cadastrado."));
        }

        if (isset($file) && !empty($file['foto_perfil']['tmp_name'])) {
            list($width, $height) = getimagesize($file["foto_perfil"]["tmp_name"]);
            if ($width < 200 || $height < 200) {
                $retorno["erros"] = array_merge($retorno["erros"], array("A foto de perfil deve ter um tamanho mínimo de 200 de largura e 200 de altura."));
            }
        }

        if (empty($retorno["erros"])) {
            $columns = array();
            $items = array();

            $date = date('Y-m-d H:i:s');

            $data['vc_senha'] = $this->encriptaSenha($data['vc_senha']);
            $data['dt_cadastro'] = $date;
            $data['dt_ultimo_acesso'] = $date;

            foreach ($data as $key => $item) {
                $columns[] = $key;
                $items[] = $item;
            }

            $this->connection->saveOrUpdate('usuarios', $columns, $items);
            $lastId = $this->connection->lastInsertId();

            $_SESSION['user_id'] = $lastId;

            # Inserção da foto de perfil
            if (!empty($file["foto_perfil"]["tmp_name"])) {
                $this->cadastrarFotoPerfil($file["foto_perfil"]);
            }

            $this->connection->desconectar();
            header("Location: " . __SITE_URL . "/minha-conta");
        }

        return $retorno;
    }

    private function cadastrarFotoPerfil($file)
    {
        $path = __SITE_PATH . "/assets/datafiles/{$_SESSION['user_id']}";
        Files::criarPasta($path);

        $extensoesAceitas = array("image/jpg", "image/jpeg", "image/png");
        $mimetype = $file["type"];

        $ext = explode("/", $mimetype);
        $ext = end($ext);

        if (in_array($mimetype, $extensoesAceitas)) {
            $nomeArquivo = __SITE_URL."/assets/datafiles/{$_SESSION['user_id']}/profile.{$ext}";

            # Verificamos se já existe alguma foto de perfil e excluímos
            $verificarGlob = glob($path."/profile.*");
            if (isset($verificarGlob[0])) {
                foreach ($verificarGlob as $item) {
                    unlink($item);
                }
            }

            move_uploaded_file($file["tmp_name"], "{$path}/profile.{$ext}");

            # Redimensionamos a foto de perfil
            $resize = new Resize($nomeArquivo);
            $resize->resizeImage(200, 200, "crop");
            $resize->saveImage(str_replace(__SITE_URL, __SITE_PATH, $nomeArquivo), 100);
            $resize->destroyImage();
        }
    }

    /**
    * Método responsável por alterar o cadastro do usuário
    * @param array $data : Dados novos do usuário
    * @return array
    */
    public function alterarCadastro($data, $file = null)
    {
        $this->isLogged(false, true);
        
        $retorno["erros"] = array();
        $retorno["ok"] = array();

        if (empty($data['vc_senha'])) {
            unset($data['vc_senha']);
        } else {
            $data['vc_senha'] = $this->encriptaSenha($data['vc_senha']);
        }

        $erros = $this->validar($data, $retorno["erros"]);
        
        if ($this->nomeUsuarioExiste($data['vc_nome_usuario'], $_SESSION['user_id'])) {
            $retorno["erros"] = array_merge($retorno["erros"], array("Nome de usuário já está sendo usado."));
        }

        if ($this->emailExiste($data['vc_email'], $_SESSION['user_id'])) {
            $retorno["erros"] = array_merge($retorno["erros"], array("Este e-mail já está cadastrado."));
        }

        if (isset($file) && !empty($file["foto_perfil"]["tmp_name"])) {
            list($width, $height) = getimagesize($file["foto_perfil"]["tmp_name"]);
            if ($width < 200 || $height < 200) {
                $retorno["erros"] = array_merge($retorno["erros"], array("A foto de perfil deve ter um tamanho mínimo de 200 de largura e 200 de altura."));
            }
        }

        if (empty($retorno["erros"])) {
            $retorno["ok"] = array("Dados salvos com sucesso!");
            $columns = array();
            $items = array();

            foreach ($data as $key => $item) {
                $columns[] = $key;
                $items[] = $item;
            }

            $this->connection->saveOrUpdate("usuarios", $columns, $items, $_SESSION['user_id']);
            $this->cadastrarFotoPerfil($file["foto_perfil"]);
        }

        return $retorno;
    }

    /**
    * Verifica se o nome de usuário já existe
    * @param string $nome_usuario : Nome do usuário
    * @return boolean
    */
    private function nomeUsuarioExiste($nome_usuario, $id = null)
    {
        $conditions = array("usuarios.vc_nome_usuario" => $nome_usuario);

        if (!empty($id)) {
            $condExtra = array("usuarios.id != {$id}");
            $conditions = array_merge($conditions, $condExtra);
        }

        $busca = $this->connection->find("usuarios", $conditions);

        if ($busca["count"] > 0) {
            return true;
        }

        return false;
    }

    /**
    * Verifica se o e-mail já existe
    * @param string $nome_usuario : Nome do usuário
    * @return boolean
    */
    private function emailExiste($email, $id = null)
    {
        $conditions = array("usuarios.vc_email" => $email);

        if (!empty($id)) {
            $condExtra = array("usuarios.id != {$id}");
            $conditions = array_merge($conditions, $condExtra);
        }

        $busca = $this->connection->find("usuarios", $conditions);

        if ($busca["count"] > 0) {
            return true;
        }

        return false;
    }

    /**
    * Get Facebook Access Token
    */
    public function getFbToken()
    {
        return $this->fb_token;
    }

    /**
    * Set Facebook Access Token
    * @param string $accessToken : Access Token
    */
    private function setFbToken($accessToken)
    {
        $this->fb_token = $accessToken;
    }

    /**
    * Encripta a senha e retorna o salt + senha para serem salvos
    * @param string $senha Senha sem a encriptação
    * @return string
    */
    private function encriptaSenha($senha)
    {
        $hash = crypt($senha, 'rl');
        $retorno = $hash;
        return $retorno;
    }

    /**
    * Método responsável por gerar um nome de usuário não existente
    * @return string $nome Nome de usuário gerado
    */
    public function gerarNomeUsuario($table, $col, $nome, $id = null)
    {
        $encontrou = true; # forço o WHILE a rodar ao menos 1x
        while ($encontrou) {
            $conditions = array("{$table}.{$col}" => $nome);

            if (!empty($id)) {
                $condExtra = array("{$col}.id != {$id}");
                $conditions = array_merge($conditions, $condExtra);
            }

            $busca = $this->connection->find($table, $conditions);

            $encontrou = false;
            if ($busca["count"] > 1) {
                $encontrou = true;
                $nome .= "_";
            }
        }

        return $nome;
    }

    /**
    * Método responsável por retornar uma mensagem dependendo do campo validado
    * @param $data string : $_POST/$_GET dos dados a serem validados
    * @param $erros array : Array dos erros atuais
    * @return array
    */
    private function validar($data, $erros = array())
    {
        if (!empty($data)) {
            $vazio = false;

            foreach ($data as $key => $item) {
                if (in_array($key, $this->validate) && empty($item)) {
                    $vazio = true;
                    $erros = $this->adicionarMsgErro($key, $erros);
                }
            }
        }

        return $erros;
    }

    /**
    * Método responsável por retornar uma mensagem dependendo do campo validado
    * @param $key string : Nome do campo
    * @param $erros array : Array dos erros atuais
    * @return array
    */
    private function adicionarMsgErro($key, $erros)
    {
        switch ($key) {
            case "vc_nome":
                $msg = "Por favor, preencha o campo nome.";
                break;
            case "vc_email":
                $msg = "Por favor, preencha o campo e-mail.";
                break;
            case "vc_nome_usuario":
                $msg = "Por favor, preencha o campo nome de usuário.";
                break;
            case "vc_senha":
                $msg = "Por favor, preencha o campo senha.";
                break;
        }

        return array_merge($erros, array($msg));
    }

    /**
    * Método responsável por salvar o último acesso no caso de um login
    * @param $id int : ID do usuário
    * @return boolean
    */
    private function salvarUltimoAcesso($id)
    {
        $columns = array('dt_ultimo_acesso');
        $items = array(date('Y-m-d H:i:s'));

        $this->connection->saveOrUpdate("usuarios", $columns, $items, $id);
        return true;
    }

    /**
    * Método responsável por verificar se está logado
    * @param $redirect boolean - Redireciona para a página "minha-conta"
    * @param $redirectIndex boolean - Redireciona para a página inicial se não estiver logado
    * @return boolean
    */
    public function isLogged($redirect = false, $redirectIndex = false)
    {
        if (isset($_COOKIE['accessToken']) && !empty($_COOKIE['accessToken'])) {
            $this->setFbToken($_COOKIE['accessToken']);

            if ($redirect) {
                $this->loginUsuarioFacebook();
            }

            return true;
        }

        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            if ($redirect) {
                header("Location: " . __SITE_URL . "/minha-conta");
            }

            return true;
        }

        if ($redirectIndex) {
            header('Location: ' . __SITE_URL . '/');
        }
    }

    public static function sair()
    {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
        }

        if (isset($_COOKIE['accessToken']) && !empty($_COOKIE['accessToken'])) {
            setcookie('accessToken', null, time()-(60*60*24*2), '/');
        }

        header('Location: ' . __SITE_URL . '/');
    }
}
