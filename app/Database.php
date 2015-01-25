<?php
namespace Vendor;

class Database {

	private $db = 'mkt';
	private $host = '127.0.0.1';
	private $user = 'root';
	private $password = '';
	private $connection = null;
	public $error = null;

	function __construct() {}

	private function connect() {
		$this->connection =  mysqli_connect($this->host,$this->user,$this->password);
		if($this->connection) {
			if(!mysqli_select_db($this->connection,$this->db)) {
				$this->mysqlError();
				return false;
			}
		} else {
			$this->mysqlError();
			return false;
		}
		return true;
	}

	private function mysqlError() {
		$this->error = mysqli_error($this->connection);
		$this->disconnect();
	}

	private function disconnect() {
		if($this->connection){
			mysqli_close($this->connection);
		}
		$this->connection = null;
	}
	public function query($sql){
		$result = null;
		if ($this->connect()) {
			if(!$result = mysqli_query($this->connection,$sql)){
				return false;
			}
			$this->disconnect();
			return $result;
		}
		return false;
	}

	private function query_select_to_array($data){
		$result = array();
		while($row = mysqli_fetch_array($data,MYSQL_ASSOC)){
			$result[] = $row;
		}
		return $result;
	}

	public function query_select($query, $escape = true){
		if ($escape) {
			return $this->addslashes_recursive_querys($this->query_select_to_array($this->query($query)));
		} else {
			return $this->query_select_to_array($this->query($query));
		}
	}

	public function addslashes_recursive_querys($array){
		$return = array();
		foreach($array as $id => $value){
			if(is_array($value)){
				$return[$id] = $this->addslashes_recursive_querys($value);
			} else {
				$return[$id] = addslashes($value);
			}
		}
		return $return;
	}

	function escape($string) {
		$this->connect();
		$string = mysqli_real_escape_string($this->connection,$string);
		$this->disconnect();
		return $string;
	}

}
?>