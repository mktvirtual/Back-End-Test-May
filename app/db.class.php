<?php
namespace mktInstagram;

use mktInstagram\Config;

class DB extends Config
{
    private $connection;

    public function __construct($host = null, $dbName = null, $user = null, $pass = null)
    {
        if (!empty($host)) {
            $dbConfig['host'] = $host;
            $dbConfig['dbName'] = $dbName;
            $dbConfig['user'] = $user;
            $dbConfig['pass'] = $pass;
        } else {
            $dbConfig = new Config();
            $dbConfig = $dbConfig->getDbConfig();
        }

        $this->connection = new \PDO("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbName']}", $dbConfig['user'], $dbConfig['pass']);
    }

    public function desconectar()
    {
        $this->connection = null;
    }

    /**
    * Get last insert id from PDO::lastInsertId
    */
    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    /**
    * Fazer o insert e update de acordo com os argumentos passados
      É necessário que $columns e $items estejam em ordem, exemplo:
      $columns[0] = 'vc_nome' && $items[0] = 'Meu Nome'
    */
    public function saveOrUpdate($table, $columns = array(), $items = array(), $id = null)
    {
        $statement = '';
        # Insert row
        if (!empty($columns) && !empty($items) && empty($id)) {
            $columns = implode(",", $columns);

            $items = $this->addSlashes($items);
            $items = '('.implode(",", $items).')';

            $statement = "INSERT INTO $table ({$columns}) VALUES {$items};";
        }

        # Update row
        if (!empty($columns) && !empty($items) && !empty($id)) {
            $last = count($columns) - 1;
            $items = $this->addSlashes($items);
            $conditions = '';

            foreach ($columns as $key => $col) {
                $conditions .= "{$col} = {$items[$key]}";
                if ($key < $last) {
                    $conditions .= ', ';
                }
            }

            $conditions .= " WHERE id = '{$id}';";
            $statement = "UPDATE $table SET {$conditions}";
        }

        $this->executeStatement($statement);
    }

    /**
    * Executa uma busca de acordo com as condições
    * @var $table : Nome da table
      É necessário que utilize a estrutura abaixo:
      array("$table.vc_email" => "email@email.com.br", "$table.vc_nome LIKE '%M%'");
    * @return array | "dados" : PDOStatement::fetchAll, "count" : PDOStatement::rowCount
    */
    public function find($table, $conditions = array())
    {
        if (!empty($conditions) && is_array($conditions)) {
            $findCond = '';
            $last = count($conditions) - 1;

            $pos = 0;
            foreach ($conditions as $key => $item) {
                $keyType = gettype($key);

                if ($key == "integer") {
                    $findCond .= "{$item}";
                } else {
                    $findCond .= "{$key} = '{$item}'";
                }

                if ($pos < $last) {
                    $findCond .= ' AND ';
                }

                $pos++;
            }

            $statement = "SELECT * FROM $table WHERE {$findCond};";
            $exec = $this->executeStatement($statement);

            $retorno["dados"] = $exec->fetchAll();
            $retorno["count"] = $exec->rowCount();

            return $retorno;
        }
    }

    /**
    * Executa uma busca de acordo com o ID
    * @var $table : Nome da table
    * @return array | "dados" : PDOStatement::fetchAll, "count" : PDOStatement::rowCount
    */
    public function findById($table, $id)
    {
        $conditions = array("$table.id" => $id);
        $busca = $this->find($table, $conditions);

        return $busca;
    }

    /**
    * Deleta um registro do banco de dados
    * @var $table : Nome da table
    * @var $conditions : Condições que a query deve considerar
    * @return array | "dados" : PDOStatement::fetchAll, "count" : PDOStatement::rowCount
    */
    public function delete($table, $conditions = array())
    {
        if (!empty($conditions) && is_array($conditions)) {
            $findCond = '';
            $last = count($conditions) - 1;

            $pos = 0;
            foreach ($conditions as $key => $item) {
                $keyType = gettype($key);

                if ($key == "integer") {
                    $findCond .= "{$item}";
                } else {
                    $findCond .= "{$key} = '{$item}'";
                }

                if ($pos < $last) {
                    $findCond .= ' AND ';
                }

                $pos++;
            }

            $statement = "DELETE FROM $table WHERE {$findCond};";
            $exec = $this->executeStatement($statement);

            return true;
        }

        return false;
    }

    private function executeStatement($statement)
    {
        try {
            return $this->connection->query($statement);
        } catch (\PDOException $e) {
            print "PDO Exception: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
    * Adiciona barras invertidas nos itens passados pelo argumento $items
    * @return array
    **/
    public function addSlashes($items = array())
    {
        if (!empty($items) && is_array($items)) {
            foreach ($items as $key => $item) {
                $items[$key] = "'".addslashes($item)."'";
            }
        }

        return $items;
    }
}
