<?php
/**
 * @defineLayout
 *
 * @return string Retorna o layout para a página em questão.
 */
function defineLayout(){
	global $config, $controller;
	if(isset($config["urls"][$controller])){
		$layout = $config["urls"][$controller]["layout"];
	}else{
		throw new Exception("P&aacute;gina Inexistente");
	}
	return $layout;
}

// TODO: Possível melhorar carregando por demanda o módulo
/**
 * #resolveDependencies
 *
 * @return void Resolve chamadas de scripts.
 */
function resolveDependencies(){
	global $config, $controller;
	require_once APPLICATION_PATH . "/Controller.php";
	require_once APPLICATION_PATH . "/Model.php";
	require_once APPLICATION_PATH . "/View.php";
	require_once APPLICATION_PATH . "/controllers/" . $controller . ".php";
	require_once APPLICATION_PATH . "/models/Profile.php";
	require_once APPLICATION_PATH . "/Model.php";
	require_once APPLICATION_PATH . "/Database.php";
}
?>
