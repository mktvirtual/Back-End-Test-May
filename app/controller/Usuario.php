<?php
namespace Vendor\Controller;
use Vendor;
include_once("../Controller.php");
class Usuario extends Vendor\Controller{
	public function cadastro() {
		if (!empty($this->data['POST'])) {
			$data = $this->data['POST'];
			$error = false;
			if (!isset($data['email']) || empty($data['email']) || !preg_match('/^[\w_]+@[\w\.]+$/', $data['email'])) {
				$error = true;
				$this->setError('email', 'E-mail Inválido');
			} else if (sizeof($this->Database->query_select("SELECT id FROM usuarios WHERE email = '{$this->Database->escape($data['email'])}'")) > 0) {
				$error = true;
				$this->setError('email', 'Já existe um E-mail com este cadastro');
			}
			if (!isset($data['senha']) || empty($data['senha']) || !preg_match('/^[\s\S]{4,10}$/', $data['senha'])) {
				$error = true;
				$this->setError('senha', 'Senha inválida, mínimo de 4 caracteres');
			}
			if (!isset($data['nome_completo']) || empty($data['nome_completo']) || !preg_match('/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]{4,}$/', $data['nome_completo'])) {
				$error = true;
				$this->setError('nome_completo', 'Nome Inválido, mínimo de 4 caracters, apenas letras');
			}
			if (!$error) {
				$data['senha'] = md5($data['senha']);
				if ($this->Database->query("INSERT INTO `usuarios`(`email`, `senha`, `nome`) VALUES ('{$this->Database->escape($data['email'])}', '{$this->Database->escape($data['senha'])}', '{$this->Database->escape($data['nome_completo'])}')")) {
					$this->setMsg('Cadastro Efetuado com Sucesso!');
					$this->redirect('/index');
				} else {
					$this->setMsg('Erro ao Efetuar o Cadastro');
				}
			}
		}
		$this->set('title', "Cadastro");
	}
	public function login () {
		if (!empty($this->data['POST'])) {
			$data = $this->data['POST'];
			$error = false;
			if (!isset($data['email']) || empty($data['email']) || !preg_match('/^[\w_]+@[\w\.]+$/', $data['email'])) {
				$error = true;
				$this->setError('email', 'E-mail Inválido');
			}
			if (!isset($data['senha']) || empty($data['senha']) || !preg_match('/^[\s\S]{4,10}$/', $data['senha'])) {
				$error = true;
				$this->setError('senha', 'Senha inválida, mínimo de 4 caracteres');
			}
			if (!$error) {
				$data['senha'] = md5($data['senha']);
				$id = $this->CpUsuario->checkLogin($data['email'], $data['senha']);
				if ($id) {
					$_SESSION['USUARIO']['id'] = $id;
					$_SESSION['USUARIO']['email'] = $data['email'];
					$_SESSION['USUARIO']['senha'] = $data['senha'];
					$this->setMsg('Login Efetuado com Sucesso!');
					$this->redirect('/index');
				} else {
					$this->setMsg('E-mail e Senha Inválidos');
				}
			}
		}
		$this->set('title', "Login");
	}
	public function logout() {
		$this->CpUsuario->logout();
		$this->set('title', 'Logout');
		$this->redirect('/index');
	}
	public function add_img () {
		if (!isset($this->data['SESSION']['USUARIO'])) {
			$this->redirect('/Usuario/login');
		}
		if (!empty($this->data['POST'])) {
			if (isset($this->data['FILES']['img']) && is_uploaded_file($this->data['FILES']['img']['tmp_name']) && getimagesize($this->data['FILES']['img']['tmp_name']) != false) {
				$size = getimagesize($this->data['FILES']['img']['tmp_name']);
				if ($size['mime'] != 'image/jpeg') {
					$this->setMsg('A imagem deve ser Jpeg');
					$this->redirect('/Usuario/add_img');
				} else {
					$fp = fopen($this->data['FILES']['img']['tmp_name'], 'rb');
					$tmpName = $this->data['FILES']['img']['tmp_name'];
					$fp = fopen($tmpName, 'rb');
					$imgContent = fread($fp, filesize($tmpName));
					fclose($fp);
					$imgContent = $this->Database->escape($imgContent);
					//THUMB
					$size = getimagesize($tmpName);
					$thumb_data = $tmpName;
					$aspectRatio=(float)($size[0] / $size[1]);
					$thumb_height = 100;
					$thumb_width = $thumb_height * $aspectRatio;
					$src = ImageCreateFromjpeg($thumb_data);
					$destImage = ImageCreateTrueColor($thumb_width, $thumb_height);
					ImageCopyResampled($destImage, $src, 0,0,0,0, $thumb_width, $thumb_height, $size[0], $size[1]);
					ob_start();
					imageJPEG($destImage);
					$image_thumb = ob_get_contents();
					ob_end_clean();
					$image_thumb = $this->Database->escape($image_thumb);
					//THUMB
					if ($this->Database->query("INSERT INTO imagens (`usuario_id`, `imagem`, `thumb`) VALUES ({$this->data['SESSION']['USUARIO']['id']}, '$imgContent', '$image_thumb')")) {
						$this->setMsg('Imagem Salva com Sucesso');
						$this->redirect("/Usuario/perfil?id={$this->data['SESSION']['USUARIO']['id']}");
					} else {
						$this->setMsg('Erro ao Salvar a Imagem');
						$this->redirect('/Usuario/add_img');
					}
				}
			} else {
				$this->setMsg('Imagem Inválida');
				$this->redirect('/Usuario/add_img');
			}
		}
		$this->set('title', "Adicionar Imagem");
	}
	function perfil() {
		if (!isset($this->data['GET']['id']) || !is_numeric($this->data['GET']['id'])) {
			$this->setMsg('Perfil Inválido');
			$this->redirect('/index');
		} else {
			$perfil = $this->Database->query_select("SELECT email,nome FROM usuarios WHERE id = {$this->data['GET']['id']}");
			if (!empty($perfil)) {
				$this->set('perfil', $perfil[0]);
				$fotos = $this->Database->query_select("SELECT id FROM imagens WHERE usuario_id = {$this->data['GET']['id']}");
				$this->set('fotos', $fotos);
			} else {
				$this->setMsg('Perfil Inválido');
				$this->redirect('/index');
			}
		}
		$this->set('title', 'Perfil');
	}
	function ver_foto() {
		if (!isset($this->data['GET']['id']) || !is_numeric($this->data['GET']['id'])) {
			$this->setMsg('Imagem Inválida');
			$this->redirect('/index');
		} else {
			$foto = $this->Database->query_select("SELECT id FROM imagens WHERE id = {$this->data['GET']['id']}");
			if (!empty($foto)) {
				$this->set('foto', $foto[0]['id']);
			} else {
				$this->setMsg('Foto Inválido');
				$this->redirect('/index');
			}
		}
		$this->set('title', 'Foto '.$this->data['GET']['id']);
	}
}
?>