<?php
use HojePromete\Controller;

class Index extends Controller
{
	private $_profile;
	private $_view;
	function __construct()
	{
		session_start();
		if(!isset($_SESSION["login"])){
			header("location:/login/");
		}
		$this->_profile = new ProfileDb();
	}

	public function indexAction($args)
	{
		$this->_view = new HojePromete\View($args["main"],$args["content"]);
		$this->_view->render();
	}
}
?>
