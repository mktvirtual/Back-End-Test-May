<form id="Cadastro" name="Cadastro" method="post" action="/Usuario/login">
	<?php $this->View->input('email', 'text', 'E-mail', 50);?>
	<?php $this->View->input('senha', 'password', 'Senha', 10);?>
	<input type="submit" name="button" id="button" value="Login" />
</form>