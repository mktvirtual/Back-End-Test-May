<?php
namespace mktInstagram\Model;

use mktInstagram\DB;

class Seguindo extends DB
{
    private $connection;

    public function __construct()
    {
        $this->connection = new DB('localhost', 'picture_it', 'root', '');
    }

    public function seguirUsuario($usuario_seguidor_id, $usuario_seguindo_id)
    {
        $columns = array("usuario_seguidor_id", "usuario_seguindo_id");
        $items = array($usuario_seguidor_id, $usuario_seguindo_id);

        $this->connection->saveOrUpdate("seguindo", $columns, $items);
        return true;
    }

    public function pararSeguirUsuario($usuario_id, $usuario_seguindo_id)
    {
        $conditions = array(
            "usuario_seguidor_id" => $usuario_id
            , "usuario_seguindo_id" => $usuario_seguindo_id
        );

        $this->connection->delete("seguindo", $conditions);
    }

    public function listarSeguidores($usuario_id)
    {
        $conditions = array("usuario_seguindo_id" => $usuario_id);
        $busca = $this->connection->find("seguindo", $conditions);

        $retorno["dados"] = array();
        if (!empty($busca["dados"]) && $busca["count"] > 0) {
            foreach ($busca["dados"] as $key => $item) {
                $usuarioId = $item["id"];
                $buscaUser = $this->connection->findById("usuarios", $usuarioId);
                $retorno["dados"][$key] = $buscaUser["dados"][0];
            }
        }

        $retorno["count"] = $busca["count"];
        return $retorno;
    }

    public function listarQuemSigo($usuario_id)
    {
        $conditions = array("usuario_seguidor_id" => $usuario_id);
        $busca = $this->connection->find("seguindo", $conditions);

        $retorno["dados"] = array();
        if (!empty($busca["dados"]) && $busca["count"] > 0) {
            foreach ($busca["dados"] as $key => $item) {
                $usuarioId = $item["id"];
                $buscaUser = $this->connection->findById("usuarios", $usuarioId);
                $retorno["dados"][$key] = $buscaUser["dados"][0];
            }
        }

        $retorno["count"] = $busca["count"];
        return $retorno;
    }
}
