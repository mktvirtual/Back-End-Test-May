<?php

class Model {
    protected $db;
    public $_tabela;
    public $_class = false;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';', DB_USER, DB_PASS);
        $this->db->query("SET NAMES 'utf8'");
    }

    public function insert(Array $dados)
    {
        $campos = implode('`, `', array_keys($dados));
        $valores = "'" . implode("' , '", array_values($dados)) . "'";
        $query = "INSERT INTO `{$this->_tabela}` (`{$campos}`) VALUES ($valores)";

        if (!$this->db->query($query)):
            echo "<p>Erro ao executar a Query: <br />$query</p>";
            var_dump($this->db->errorInfo());
            exit;
        endif;

        return $this->db->lastInsertId();
    }

    public function read($args = null, $forceAll = false)
    {
        $fields = isset($args['fields']) ? "{$args['fields']}" : '*';
        $where = isset($args['where']) ? "WHERE {$args['where']}" : '';
        $order = isset($args['order']) ? "ORDER BY {$args['order']}" : '';
        $limit = isset($args['limit']) ? "LIMIT {$args['limit']}" : '';
        
        $query = "SELECT {$fields} FROM `{$this->_tabela}` {$where} {$order} {$limit}";

        $rs = $this->db->query($query);
        if (!$rs):
            die("<p>Erro ao Executar: SELECT * FROM `{$this->_tabela}` {$where} {$order} {$limit}</p>");
        endif;

        if ($rs->rowCount() == 0):
            return false;
        endif;

        if ($this->_class):
            $rs->setFetchMode(PDO::FETCH_CLASS, $this->_class);
        else:
            $rs->setFetchMode(PDO::FETCH_OBJ);
        endif;
        
        if ($rs->rowCount() > 1 || $forceAll) :
            return $rs->fetchAll();
        else:
            return $rs->fetch();            
        endif;
    }

    public function update(Array $dados, $where)
    {
        foreach ($dados as $indice => $vals)
        {
            $_campos[] = sprintf("`%s`='%s'", $indice, $vals);
        }
        $campos = implode(', ', $_campos);
        $query = "UPDATE `{$this->_tabela}` SET $campos WHERE $where";

        echo $query;
        
        if (!$this->db->query($query)):
            echo "<p>Erro ao executar a Query: <br />$query</p>";
            var_dump($this->db->errorInfo());
            exit;
        endif;
        return true;
    }

    public function delete($where)
    {
        $this->db->query("DELETE FROM `{$this->_tabela}` WHERE {$where}");
    }

    public function query($sql)
    {
        return $this->db->query($sql);        
    }

}
?>