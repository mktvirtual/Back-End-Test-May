<?php
namespace Vendor;
include_once('../Database.php');
abstract class Core {
	function __construct() {
		$this->Database = new Database();
	}
	// Função para ser utilizada APENAS DURANTE O DESENVOLVIMENTO
	public function pr($var) {
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
}
?>