<?php 

/**
 * 
 */
class UserSession {
	
	public function __construct()
	{
		session_start();
	}

	public function setCurrentUser($id_user)
	{
		/*$_SESSION['auth'] = "yes";
		$_SESSION["id"] = $id_user;*/
		// echo "Session Create ->".$id_user."<-";
		// $_SESSION["perfil"] = $profile;
		// print_r($id_user);
		session_id($id_user);
		$_SESSION["id_user"] = $id_user;
		// print_r($_SESSION);
	}

	public function getCurrentUser()
	{
		// print_r($_SESSION);
		// return $_SESSION["id_user"];
		return session_id();
		// $user_session = session_id();
		// return session_decode($user_session);
	}
	

	public function closeSession()
	{
		session_unset();
		session_destroy();
	}
}

?>