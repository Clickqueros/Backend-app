<?php 

    header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
	header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	session_start();
	include("mail.php");
	include("user_session.php");
	include("database.php");
	include("queries.php");

	function userLogged(){
		try{
			$userSession = new UserSession();
			$id_user = $userSession->getCurrentUser();
			if(isset($id_user)){
			    return json_encode(array("code"=>200,"response"=>$id_user));
			}
			else{
				return json_encode(array("code"=>300,"response"=>"No hay usuario logeado"));
			}
		}
		catch(Exception $e){
			return json_encode(array("code"=>500,"response"=>$e));
		}
	}

	function make_login($base,$user,$password){
		try{
			if(isset($base)){
				$login = loginUser($base,$user,$password);
			    return $login;
			}
			else{
				return json_encode(array("code"=>300,"response"=>"No hay usuario logeado"));
			}
		}
		catch(Exception $e){
			return json_encode(array("code"=>500,"response"=>$e));
		}
	}

	function get_all_referenced($base){
		try{
			if(isset($base)){
				$refenced = getAllReferenced($base);
			    return $refenced;
			}
			else{
				return json_encode(array("code"=>300,"response"=>"No hay usuario logeado"));
			}
		}
		catch(Exception $e){
			return json_encode(array("code"=>500,"response"=>$e));
		}
	}

	function update_status($base,$id_refer,$status){
		try{
			if(isset($base) && isset($id_refer) && isset($status)){
				$updStatus = updateStatus($base,$id_refer,$status);
			    return $updStatus;
			}
			else{
				return json_encode(array("code"=>400,"response"=>"Faltan datos por ingresar."));
			}
		}
		catch(Exception $e){
			return json_encode(array("code"=>500,"response"=>$e));
		}
	}

	function update_discount($base,$id_refer,$discount){
		try{
			if(isset($base) && isset($id_refer) && isset($discount)){
				$updDiscount = updateDiscount($base,$id_refer,$discount);
			    return $updDiscount;
			}
			else{
				return json_encode(array("code"=>400,"response"=>"Faltan datos por ingresar."));
			}
		}
		catch(Exception $e){
			return json_encode(array("code"=>500,"response"=>$e));
		}
	}

	$base = $db[$_POST["base"]];

	switch ($_POST["param"]) {
		case 'getUserLogged':
			echo userLogged();
			break;
		case 'loginUser':
			echo make_login($base,$_POST["user"],$_POST["password"]);
			break;
		case 'getAllReferenced':
			echo get_all_referenced($base);
			break;
		case 'updateStatus':
			echo update_status($base,$_POST["id_refer"],$_POST["status"]);
			break;
		case 'updateDiscount':
			echo update_discount($base,$_POST["id_refer"],$_POST["discount"]);
			break;
		default:
			echo $_POST["param"];
			break;
	}

 ?>