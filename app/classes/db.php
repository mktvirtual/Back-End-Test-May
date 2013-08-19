<?php

class db {

    //Configuração do Banco de dados
    private $config = array(
        "host" => "mysql02.syntex.com.br",
        "user" => "syntex1",
        "password" => "a3n73r4l6@77@",
        "database" => "syntex1"
    );
    //Verificação se tem sessão aberta no mysql
    private $connected;
    //Conexão com o banco
    private $connection;
    //Resultados das queries
    private $results;

    public function connect() {
        $this->connection = mysql_connect($this->config["host"], $this->config["user"], $this->config["password"]);
        if (mysql_select_db($this->config["database"], $this->connection)):
            $this->connected = true;
        endif;
        return $this->connection;
    }

    public function disconnect() {
        if (mysql_close($this->connection)) {
            $this->connected = false;
            $this->connection = null;
        }
        return !$this->connected;
    }

    public function getConnection() {
        if (!$this->connected){
            $this->connect();
        }
        return $this->connection;
    }

    public function query($sql = null) {
        $this->results = mysql_query($sql, $this->getConnection());
        return $this->results;
    }

    public function fetch($sql = null) {
        if (!is_null($sql) && !$this->query($sql)){
            return false;
        }elseif ($this->hasResult()){
            $results = array();
            while($result = $this->fetchRow()):
                $results []= $result;
            endwhile;
            return $results;
        }else{
            return null;
        }
    }

    public function hasResult() {
        return is_resource($this->results);
    }

    public function fetchRow($results = null) {
        $results = is_null($results) ? $this->results : $results;
        return mysql_fetch_assoc($results);
    }

}

?>
