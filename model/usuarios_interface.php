<?php
namespace mktInstagram\Model;

interface UsuariosInterface
{
    public function gerarNomeUsuario($table, $col, $nome, $id = null);
}
