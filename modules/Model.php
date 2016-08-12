<?php
namespace HojePromete;
abstract class Model
{
	function __construct()
	{
		$this->Database = new Database();
	}
	public function Insert($params,$table){
		$cols = array();
		$vals = array();
		foreach($params as $key => $value){
			$cols[] = '`'.$key.'`';
			$vals[] = '"'.$value.'"';
		}
		$cols[] = "`inserted`";
		$vals[] = '"'.date("Y-m-d H:i:s").'"';
                $sql = "INSERT INTO ".$table."(" . implode(",",$cols) . ") VALUES (" . implode(",",$vals) . ")";
		$this->Database->query($sql);
	}
	public function Select($params,$table){
		$query = array();
		$sql = "SELECT * FROM " . $table;
		if(count($params) > 1){
			foreach($params as $key => $value){
				$query[] = "`" . $key . "`" . " = " . '"'.$value.'"';
			}
			$sql = "SELECT * FROM " . $table . " WHERE ".implode(" AND ",$query);
		}
		return $this->Database->query_select($sql);
	}
}
?>
