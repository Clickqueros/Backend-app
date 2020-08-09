<?php 

error_reporting(0);
session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
$db = array('pruebas'=>'clickque_secure');

function conectDB($db){
	$mysqli = new mysqli("127.0.0.1","clickque_secure","Secure2020@",$db);
	if ($mysqli->connect_errno) {
		// "La conexión fallo";
		echo "Errno".$mysqli->connect_errno;
		exit;
	} 
	$mysqli->set_charset("utf8");
	return $mysqli;
}

function apiKey($session_uid){
	$key = md5(SITE_KEY.$session_uid);
	return hash('sha256',$key);
}

?>