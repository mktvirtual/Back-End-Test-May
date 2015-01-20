<article id="conteudo">
	<h1>Novo Cadastro</h1>
	<p>Preencha os campos abaixo com os seus dados para cadastrar-se:</p>

	<?php include __SITE_PATH . '/views/elements/msg_erros_save.php'; ?>

	<form action="" method="post" class="cadastro" enctype="multipart/form-data">
		<label for="vc_nome" class="col1">
	      <span>Nome Completo *</span>
	      <input type="text" name="data[vc_nome]" value="<?php echo @$_POST['data']['vc_nome']; ?>" />
	    </label>

	    <label for="vc_email" class="col1">
	      <span>E-mail *</span>
	      <input type="text" name="data[vc_email]" value="<?php echo @$_POST['data']['vc_email']; ?>" />
	    </label>

	    <label for="vc_login" class="col1">
			<span>Nome de Usuário *</span>
			<input type="text" name="data[vc_nome_usuario]" value="<?php echo @$_POST['data']['vc_nome_usuario']; ?>" />
		</label>

		<label for="vc_senha" class="col1">
			<span>Senha * <em>limite de 8 caracteres</em></span>
			<input type="password" name="data[vc_senha]" value="<?php echo @$_POST['data']['vc_senha']; ?>" />
		</label>

		<label for="vc_senha" class="col2">
			<span>Foto de Perfil * <em>dimensões mínimas de 200x200px</em></span>
			<input type="file" name="foto_perfil" />
		</label>

	    <label>
	      <button type="submit" class="btn">Enviar</button>
	    </label>
	</form>
</article>