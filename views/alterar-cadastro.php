<article id="conteudo">
	<h1>Alterar Cadastro</h1>
	<p>Para alterar os seus dados, preencha os campos abaixo:</p>

	<?php include __SITE_PATH . '/views/elements/msg_erros_save.php'; ?>

	<form action="" method="post" class="cadastro" enctype="multipart/form-data">
		<label for="vc_nome" class="col1">
	      <span>Nome Completo *</span>
	      <input type="text" name="data[vc_nome]" value="<?php echo @$usuario['vc_nome']; ?>" />
	    </label>

	    <label for="vc_email" class="col1">
	      <span>E-mail *</span>
	      <input type="text" name="data[vc_email]" value="<?php echo @$usuario['vc_email']; ?>" />
	    </label>

	    <label for="vc_login" class="col1">
			<span>Nome de Usuário *</span>
			<input type="text" name="data[vc_nome_usuario]" value="<?php echo @$usuario['vc_nome_usuario']; ?>" />
		</label>

		<label for="vc_senha" class="col1">
			<span>Nova Senha * <em>limite de 8 caracteres</em></span>
			<input type="password" name="data[vc_senha]" value="<?php echo @$_POST['data']['vc_senha']; ?>" />
		</label>

		<label for="tx_descricao" class="col1">
			<span>Descrição * <em>limite de 100 caracteres</em></span>
			<input type="text" name="data[tx_descricao]" maxlength="100" value="<?php echo @$usuario['tx_descricao']; ?>" />
		</label>

		<label for="vc_senha" class="col1">
			<span>Nova Foto de Perfil * <em>dimensões mínimas de 200x200px</em></span>
			<input type="file" name="foto_perfil" />
		</label>

	    <label>
	      <button type="submit" class="btn">Alterar Cadastro</button>
	    </label>
	</form>
</article>