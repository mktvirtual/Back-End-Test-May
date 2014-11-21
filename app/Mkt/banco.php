<?php 
    
    namespace Mkt;

    class db 
    {
        public $isConectado;
        public $datab;
        public function __construct($username = 'root', $password = '', $host = 'localhost', $dbname = 'rodolfo', $options=array()){
            $this->isConectado = true;
            try { 
                $this->datab = new \PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); 
                $this->datab->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
                $this->datab->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            } 
            catch(PDOException $e) { 
                $this->isConectado = false;
                throw new Exception($e->getMessage());
            }
        }
        public function Desconectar(){
            $this->datab = null;
            $this->isConectado = false;
        }
        public function getLinha($query, $params=array()){
            try{ 
                $stmt = $this->datab->prepare($query); 
                $stmt->execute($params);
                return $stmt->fetch();  
                }catch(PDOException $e){
                throw new Exception($e->getMessage());
            }
        }
        public function getLinhas($query, $params=array()){
            try{ 
                $stmt = $this->datab->prepare($query); 
                $stmt->execute($params);
                return $stmt->fetchAll();       
                }catch(PDOException $e){
                throw new Exception($e->getMessage());
            }       
        }
        public function insertRegistro($query, $params){
            try{ 
                $stmt = $this->datab->prepare($query); 
                $stmt->execute($params);
                }catch(PDOException $e){
                throw new Exception($e->getMessage());
            }           
        }
        public function updateRegistro($query, $params){
            return $this->insertRow($query, $params);
        }
        public function deleteRegistro($query, $params){
            return $this->insertRow($query, $params);
        }
    }

