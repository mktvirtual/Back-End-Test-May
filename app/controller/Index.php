<?php
namespace Vendor\Controller;
use Vendor;
include_once("../Controller.php");
class Index extends Vendor\Controller{
	function index() {
		$this->set('title', "Página Inicial");
	}
}
?>