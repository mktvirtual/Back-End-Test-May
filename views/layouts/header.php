<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $title; ?> | Picture It</title>
	<meta charset="utf-8" />
	<meta name='language' content='pt-br' />
	
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <?php
    $cssPadrao = array("fonts", "global");
    $css = array_merge($cssPadrao, $css);

    if (isset($css) && is_array($css)) {
        foreach ($css as $item) {
            echo "<link rel='stylesheet' href='" . __ASSETS_PATH . "/css/{$item}.css' />";
        }
    }

    $jsPadrao = array("jquery-1-11-2", "onload");
    $js = array_merge($jsPadrao, $js);

    if (isset($js) && is_array($js)) {
        foreach ($js as $item) {
            echo "<script type='text/javascript' src='" . __ASSETS_PATH . "/js/{$item}.js'></script>";
        }
    }
    ?>
</head>
<body>

<nav id="menu">
    <ul>
        <li class="liTitulo">Menu de Navegação</li>
        <?php
        if (!isset($_SESSION['user_id'])) {
            echo "<li><a href='".__SITE_URL."' title='Home'>Home</a></li>";
        } else {
            echo "<li><a href='".__SITE_URL."/minha-conta' title='Minha Conta'>Minha Conta</a></li>";
            echo "<li><a href='".__SITE_URL."/cadastro/sair' title='Sair'>Sair</a></li>";
        }
        ?>        
    </ul>
</nav>

<header>
    <?php
    if (!isset($nomeUsuario)) {
        echo '<a href="'.__SITE_URL.'" title="Picture It!"><img src="'.__ASSETS_PATH . "/images/logo.png" . '" border="0" /></a>';
        echo '<h1><a href="'.__SITE_URL.'" title="Picture It!">Pit!</a></h1>';
    } else {
        echo '<h1><a href="'.__SITE_URL.'" title="Picture It!" style="margin-top:0.4em; margin-right:2%;">'.ucwords($nomeUsuario).'</a></h1>';
        echo '<a href="'.__SITE_URL.'" title="Picture It!"><img src="'.__ASSETS_PATH . "/images/logo.png" . '" border="0" /></a>';
    }
    ?>
    <a title="Abrir Menu" id="abrirMenu" class="fa fa-navicon fa-3x"></a>
</header>
