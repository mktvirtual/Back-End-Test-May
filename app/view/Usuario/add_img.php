<form method="post" action="/Usuario/add_img" enctype="multipart/form-data">
	<?php $this->View->input('img', 'file', 'Selecione uma Imagem Jpeg:');?>
	<input type="submit" name="button" id="button" value="Enviar" />
</form>