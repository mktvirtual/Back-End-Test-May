<?php
use HojePromete\Controller;

class Login extends Controller
{
	private $_profile;
	private $_view;
	function __construct()
	{
		$this->_profile = new ProfileDb();
	}

	public function indexAction($args)
	{
		$this->_view = new HojePromete\View($args["main"],$args["content"]);
		$this->_view->render();
	}
}
?>
