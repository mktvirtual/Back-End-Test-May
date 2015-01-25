<?php 
namespace Vendor\Component;
include_once('../Core.php');
use Vendor;
class CpUsuario extends Vendor\Core{
	public function checkLogin ($email, $senha) {
		$result = $this->Database->query_select("SELECT id FROM usuarios WHERE email = '{$this->Database->escape($email)}' AND senha = '{$this->Database->escape($senha)}'");
		if (sizeof($result)) {
			return $result[0]['id'];
		} else {
			return false;
		}
	}
	public function logout() {
		session_destroy();
	}
}
?>