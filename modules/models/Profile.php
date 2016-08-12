<?php
use HojePromete\Model;

class ProfileDb extends Model
{
	function __construct()
	{
		parent::__construct();
	}
	public function register($params){
		parent::Insert($params,"users");
	}
	public function registerFb($params,$fb){
		parent::Insert($params,"users");
		parent::Insert($fb,"users_facebook");
	}
	public function verify($params){
		$select = parent::Select($params,"users");
		if(isset($select[0])){
			return $select[0];
		}
	}
}
?>
