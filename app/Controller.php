<?php
namespace Vendor;
include_once('../Core.php');
include_once('../View.php');
use Vendor\Component as Component;
include_once('../component/cp_usuario.php');
class Controller extends Core{
	var $action = null;
	var $controller = null;
	var $data = null;
	var $Database = null;
	var $set = array();
	var $error = array();
	var $View = null;

	function __construct() {
		$this->CpUsuario = new Component\CpUsuario();
		parent::__construct();
	}

	public function set($name, $value) {
		$this->set[$name] = $value;
	}

	public function setError($id, $msg) {
		$this->error[$id] = $msg;
	}
	public function render() {
		if (file_exists('../view/'  . $this->controller . "/" . $this->action . ".php")) {
			foreach ($this->set as $name => $value) {
				$$name = $value;
			}
			$this->View = new View();
			$this->View->error = $this->error;
			$this->View->data = $this->data;
			$usuario = null;
			if (isset($_SESSION['USUARIO'])) {
				if ($this->CpUsuario->checkLogin($_SESSION['USUARIO']['email'], $_SESSION['USUARIO']['senha'])) {
					$usuario = $_SESSION['USUARIO'];
				}
			}
			if (isset($this->file) && $this->file) {
				include '../view/'  . $this->controller . "/" . $this->action . ".php";
			} else {
				$this->View->header($title, $usuario);
				include '../view/'  . $this->controller . "/" . $this->action . ".php";
				$this->View->footer();
			}
		} else {
			header("HTTP/1.0 404 Not Found");
		}
	}
	public function setMsg($msg) {
		$_SESSION['MSG'] = $msg;
	}
	public function redirect($link){
		session_write_close();
		header("Location: ".$link);
	}
}
?>