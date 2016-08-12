<?php
class Error{
	function __construct(){
	}
	public function indexAction($args){
		echo $args["content"];
	}
}
?>
