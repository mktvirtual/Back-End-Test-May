<?php
namespace Vendor;
include_once('../Core.php');
class View extends Core{

	function __construct() {}

	var $error = array();
	var $data = array();
	public function header($title, $usuario = null) {
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="/style/main.css">
		<title><?php echo $title; ?></title>
		</head>
		<body>
		<div id="body">
			<div id="header">
				<a href="/Index"><img name="PlaceHolder" src="" width="230" height="80" alt="PlaceHolder" style="background-color: #999999" /></a>
			</div>
			<div id="menu">
				<a href="/index">Início</a>
				<?php
					if ($usuario == null) :?>
						<a href="/Usuario/cadastro">Cadastre-se</a>
						<a href="/Usuario/login">Login</a>
				<?php else: ?>
					<a href="/Usuario/perfil?id=<?php echo $usuario['id'];?>">Perfil</a>
					<a href="/Usuario/add_img">Adicionar Foto</a>
					<a href="/Usuario/logout">Logout</a>
				<?php
					endif;
				?>
			</div>
			<div id="main">
			<?php 
				if (isset($_SESSION['MSG'])) {
					echo "<div class='msg_div'><h2><span class='msg'>{$_SESSION['MSG']}</span></h2></div>";
					unset($_SESSION['MSG']);
				}
			?>
			<h2><?php echo $title; ?></h2>
		<?php 
	}

	public function footer() {
		?>
			</div>
		</div>
		</body>
		</html>
		<?php
	}

	public function input($id, $type, $label, $length = null) {?>
		<label for="<?php echo $id; ?>"><?php echo $label ?></label>
		<br />
		<input type="<?php echo $type; ?>" name="<?php echo $id; ?>" id="<?php echo $id; ?>" <?php echo (($length)?'maxlength="'.$length.'"':''); ?> <?php echo ((isset($this->data['POST'][$id]))?"value='".$this->data['POST'][$id]."'":'');?>/>
		<?php $this->Error($id);?>
		<br />
		<br />
		<?php
	}

	public function error($id) {
		if (isset($this->error[$id])) : ?>
			<div class="error_msg"><?php echo $this->error[$id]; ?></div>
		<?php
		endif;
	}
}
?>