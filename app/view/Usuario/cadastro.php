<form id="Cadastro" name="Cadastro" method="post" action="/Usuario/cadastro">
	<?php $this->View->input('email', 'text', 'E-mail', 50);?>
	<?php $this->View->input('senha', 'password', 'Senha', 10);?>
	<?php $this->View->input('nome_completo', 'text', 'Nome Completo');?>
	<input type="submit" name="button" id="button" value="Cadastrar" />
</form>