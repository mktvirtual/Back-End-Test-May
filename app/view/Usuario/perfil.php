<style>
#perfil {
	float:left;
	width: 15%;
	border:1px solid black;
	margin-right:5px;
	min-height:600px;
}
#fotos img {
	margin: 5px;
}
#fotos {
	float:left;
	width: 75%;
	border:1px solid black;
	min-height:600px;
}
</style>
<div id="perfil">
<h2>Sobre:</h2>
<br />
E-mail: <?php echo $perfil['email']; ?>
<br />
<br />
Nome: <?php echo $perfil['nome']; ?>
</div>
<div id="fotos">
<?php foreach($fotos as $value):?>
	<a href="/Usuario/ver_foto?id=<?php echo $value['id']; ?>"><img src="/Imagem/imagem?id=<?php echo $value['id']; ?>&thumb=1" /></a>
<?php endforeach; ?>
</div>