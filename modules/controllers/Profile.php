<?php
use HojePromete\Controller;

class Profile extends Controller
{
	private $_profile;
	function __construct()
	{
		$this->_profile = new ProfileDb();
	}

	public function indexAction($args)
	{
		echo $args["content"];
	}
}
?>
