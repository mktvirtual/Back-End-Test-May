<article id="conteudo">
	<h1>Bem-vindo ao <span>Picture It</span></h1>
	<p>Conheça a nova maneira de compartilhar fotos com o mundo todo sem pagar nada por isso! No <strong>Picture It</strong> você pode de forma rápida, simples e divertida publicar suas fotos preferidas.</p>
	<p>Se você ainda não se cadastrou, você pode fazer isso clicando <a href="<?php echo __SITE_URL . "/cadastro"; ?>">aqui!</a></p>

  <?php include __SITE_PATH . '/views/elements/msg_erros_save.php'; ?>

	<form action="" method="post">
		<label for="login">
			<span>Nome de Usuário</span>
			<input type="text" name="data[vc_nome_usuario]" value="<?php echo @$_POST['data']['vc_nome_usuario']; ?>" />
		</label>

		<label for="senha">
			<span>Senha</span>
			<input type="password" name="data[vc_senha]" maxlength="8" value="<?php echo @$_POST['data']['vc_senha']; ?>" />
		</label>
	    <label>
	      <button type="submit" class="btn">Entrar</button>
	    </label>
	</form>

	<div id="fbLogin">
  		<a href="<?php echo $loginUrl; ?>" title="Log in with Facebook"><img src="<?php echo __SITE_URL . "/assets/images/loginFacebook.jpg"; ?>" /></a>
  	</div>

  	<br class="clear" />
</article>