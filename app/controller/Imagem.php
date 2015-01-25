<?php
namespace Vendor\Controller;
use Vendor;
include_once("../Controller.php");
class Imagem extends Vendor\Controller{
	var $file = true;
	function imagem() {
		if (!isset($this->data['GET']['id']) || !is_numeric($this->data['GET']['id'])) {
			header("HTTP/1.0 404 Not Found");
		} else {
			if (isset($this->data['GET']['thumb']) && $this->data['GET']['thumb']) {
				$imagem = $this->Database->query_select("SELECT thumb FROM imagens WHERE id = {$this->data['GET']['id']}", false);
				if (empty($imagem)) {
					header("HTTP/1.0 404 Not Found");
				} else {
					$imagem = $imagem[0]['thumb'];
					$this->set('imagem', $imagem);
				}
			} else {
				$imagem = $this->Database->query_select("SELECT imagem FROM imagens WHERE id = {$this->data['GET']['id']}", false);
				if (empty($imagem)) {
					header("HTTP/1.0 404 Not Found");
				} else {
					$imagem = $imagem[0]['imagem'];
					$this->set('imagem', $imagem);
				}
			}
		}
	}
}
?>