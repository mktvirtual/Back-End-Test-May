<article id="conteudo" class="enviaFotoPage">

	<h1>Enviar Foto</h1>
	<p>Arraste a área de corte até onde desejar e clique em recortar</p>

	<img src="<?php echo $tempFile; ?>" alt="Recortar Foto" id="cropbox" />

	<form action="<?php echo __SITE_URL . "/retorno/envia-foto"; ?>" class="cadastro" method="post" onsubmit="return checkCoords();"> 
		<input type="hidden" id="x" name="x" /> 
		<input type="hidden" id="y" name="y" /> 
		<input type="hidden" id="w" name="w" /> 
		<input type="hidden" id="h" name="h" /> 
		<input type="hidden" name="file" value="<?php echo $tempFile; ?>" />
		<label class="col1">
			<span>Legenda a foto</span>
			<input type="text" name="legenda" />
		</label>

		<label class="col2">
			<button type="submit" class="btn">Recortar Foto</button> 
		</label>
	</form>
</article>