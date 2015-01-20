<article id="conteudo">
    <section id="userInfo">
	    <div class="floatLeft" id="imgHolder">
			<img src="<?php echo $profile_pic; ?>" alt="" />
		</div>

		<div class="floatLeft" id="followInfo">
			<div class="smallInfo"><?php echo $nrPublicacoes; ?> <span>publicações</span></div>
			<div class="smallInfo">0 <span>seguidores</span></div>
			<div class="smallInfo">0 <span>seguindo</span></div>

			<br class="clear" />

			<form method="post" action="<?php echo __SITE_URL . '/minha-conta/envia-foto'; ?>" enctype="multipart/form-data">
				<a class="btnCinza" title="Alterar Perfil" href="<?php echo __SITE_URL . '/minha-conta/alterar'; ?>">Alterar Perfil</a>
				<a class="btnCinza" title="Enviar Foto" id="enviarFotoLink">Enviar Foto</a>
				<input type="file" name="data[foto]" id="enviarFoto" />
			</form>
		</div>

        <br class="clear" />

        <div id="userNameDesc">
        <?php
        echo "<h1>{$usuario["vc_nome"]}</h1>";
        if (!empty($usuario["tx_descricao"])) {
            echo "<p>{$usuario['tx_descricao']}</p>";
        }
        ?>
        </div>
	</section>

	<section id="photoFeed">
		<?php
		if (!empty($fotosUser) && is_array($fotosUser)) {
            echo '<ul class="listaFotos">';
                foreach ($fotosUser as $item) {
                	echo "<li><a href='{$item['url_grande']}' title='{$item['legenda']}' rel='lightbox[fotos]'><img src='{$item['url']}' /></a></li>";
                }
            echo '</ul>';
		} else {
			echo "<strong class='alerta'>Nenhuma foto foi inserida</strong>";
		}
		?>
	</section>

	<br class="clear" />
</article>