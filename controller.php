<?php 

    // header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
    header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
	header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

	$input = file_get_contents('php://input'); 
	// print_r($_POST);
	$data = json_decode($input, true);
	// print_r($data);
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	//echo json_encode($data);
	session_start();
	include("mail.php");
	include("user_session.php");
	include("database.php");
	include("queries.php");

	function userLogged(){
		try{
			$userSession = new UserSession();
			$id_user = $userSession->getCurrentUser();
			// $id_user = $_SESSION["id_user"];
			if(isset($id_user)){
			// if(isset($_SESSION["id"])){
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

	function new_referencing($base,$data){
		try{
			if(isset($base) && $data["document"] != ""){
				$newRefer = createReferencing($base,$data);
			    return $newRefer;
			}
			else{
				return json_encode(array("code"=>400,"response"=>"Todos los datos son requeridos..."));
			}
		}
		catch(Exception $e){
			return json_encode(array("code"=>500,"response"=>$e));
		}
	}

	function new_user($base,$data){
		try{
			if(isset($base) && $data["names"] && $data["last_names"] != "" && $data["document"] != "" && $data["email"] != "" && $data["mobile"] != ""){
				$newUser = createUser($base,$data);
			    return $newUser;
			}
			else{
				return json_encode(array("code"=>400,"response"=>"Todos los datos son requeridos..."));
			}
		}
		catch(Exception $e){
			return json_encode(array("code"=>500,"response"=>$e));
		}
	}

	function act_user($base,$data){
		try{
			if(isset($base)){
				$actUser = updateUser($base,$data);
			    return $actUser;
			}
			else{
				return json_encode(array("code"=>400,"response"=>"Todos los datos son requeridos..."));
			}
		}
		catch(Exception $e){
			return json_encode(array("code"=>500,"response"=>$e));
		}
	}

	$base = $db[$data["base"]];

	switch ($data["param"]) {
		case 'loginUser':
			echo makeLogin($base,$data);
			break;
		case 'getInfoUser':
			echo getInfoUser($base,$data);
			break;
		case 'getUserLogged':
			echo userLogged();
			break;
		case 'newReferencing':
			echo new_referencing($base,$data);
			break;
		case 'newUser':
			echo new_user($base,$data);
			break;
		case 'actUser':
			echo act_user($base,$data);
			break;
		case 'getReferred':
			echo getReferencing($base,$data);
			break;
		case 'forgotPassword':
			echo forgotPassword($base,$data);
			break;
		default:
			echo $data["param"];
			break;
	}

 ?>