<?php
use HojePromete\Controller;

class Login extends Controller
{
	private $_profile;
	private $_view;
	private $_facebook;
	function __construct()
	{
		session_start();
		if(isset($_SESSION["login"])){
			header("location:/");
		}
		$this->_profile = new ProfileDb();
		$this->_facebook = new Facebook(array('appId' => '240477552773562','secret' => 'a8172fa334c595d5f4ae649ba17ce134'));
	}

	public function indexAction($args)
	{
		$this->_view = new HojePromete\View($args["main"],$args["content"]);
		$vars = array();
		if(!$user = $this->_facebook->getUser()){
			$url = $this->_facebook->getLoginUrl(array('redirect_url' => 'http://beta.hojepromete.com.br/','scope' => 'user_status,user_photos,email,user_birthday,user_location,friends_photos,user_events,friends_events'));
			$this->_view->fb = $this->_view->assign($url);
		}else{
			try {
				$user_profile = $this->_facebook->api('/me');
				if(isset($user_profile)){
					//$data_user = $this->_users->getByfacebookID($user_profile["id"]);
				}
			} catch (FacebookApiException $e) {
				print_r($e);
			}
		}
		if(isset($_POST["register"])){
			$this->_profile->register($_POST["register"]);
		}
		if(isset($_POST["login"])){
			$user = $this->_profile->verify($_POST["login"]);
			if(isset($user["username"])){
				$_SESSION["login"] = $user;
				header("location:/");
			}
		}
		$this->_view->render();
	}
}
?>
