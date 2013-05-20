<?php
require '../../vendor/autoload.php';

$facebook = new Facebook(array(
  'appId'  => 'ADD_ID',
  'secret' => 'APP_SECRET',
  'cookie' => true,
)); 

$user = $facebook->getUser();

if ($user) {
	try {
		$user_profile = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
}