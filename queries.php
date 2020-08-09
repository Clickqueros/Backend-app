<?php 

	function makeLogin($base,$data){
		try {
			$connect = conectDB($base);
			$user = base64_decode($data["user"]);
			$pass = base64_decode($data["pass"]);
			$userData = array();
			$userSession = new UserSession();
			$sql = "SELECT id_user, names, last_names, document,  mobile, email
					FROM users 
					WHERE email = '$user'";
			$query = $connect->query($sql);
			if ($query->num_rows > 0) {
				$result = array();
				$data = $query->fetch_assoc();
				if ($pass == $data["document"]) {
					$id_user = $data["id_user"];
					$result = array("id_user"=>$data["id_user"],"names"=>$data["names"],"last_names"=>$data["last_names"],"document"=>$data["document"],"mobile"=>$data["mobile"],"email"=>$data["email"]);
					$userData = array("code"=>200,"result"=>true, "response"=>$result);
					$userSession->setCurrentUser($id_user);
				}
				else {
					$userData = array("code"=>300,"result"=>false, "response"=>"La contraseña no es correcta");	
				}
			}
			else {
				$userData = array("code"=>400,"result"=>false, "response"=>"El usuario no está registrado");	
			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}

	function loginUser($base,$user,$password){
		try {
			$connect = conectDB($base);
			$user = base64_decode($user);
			// $password = base64_decode($password);
			// $password = base64_decode($password);
			$userData = array();
			$userSession = new UserSession();
			$sql = "SELECT id_user, password
					FROM users_admin
					WHERE user = '$user' AND status = 1";
			$query = $connect->query($sql);
			if ($query->num_rows > 0) {
				$data = $query->fetch_assoc();
				if ($password == $data["password"]) {
					$result = array();
					$id_user = $data["id_user"];
					$userSession->setCurrentUser($id_user);
					$result = array("id_user"=>$data["id_user"]);
					$userData = array("code"=>200,"result"=>true, "response"=>$result);
					// $id_user = $data["id_user"];
				}
				else {
					$userData = array("code"=>300,"result"=>false, "response"=>"La contraseña no es correcta");	
				}
			}
			else {
				$userData = array("code"=>400,"result"=>false, "response"=>"El usuario no está registrado");	
			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}

	function getInfoUser($base,$data){
		try {
			$connect = conectDB($base);
			// $user = base64_decode($data["id_user"]);
			// $id_user = $data["id_user"];
			$id_user = 7;
			$userData = array();
			$sql = "SELECT id_user, names, last_names, CONCAT(names,' ', last_names) as name_complete, document,  mobile, email, photo
					FROM users 
					WHERE id_user = '$id_user'";
			$query = $connect->query($sql);
			if ($query->num_rows > 0) {
				$result = array();
				while ($data = $query->fetch_assoc()) {
					// array_push($result, array("id_user"=>$data["id_user"],"names"=>$data["names"],"last_names"=>$data["last_names"],"name_complete"=>$data["name_complete"],"document"=>$data["document"],"mobile"=>$data["mobile"],"email"=>$data["email"]));
					$result = array("id_user"=>$data["id_user"],"names"=>$data["names"],"last_names"=>$data["last_names"],"name_complete"=>$data["name_complete"],"document"=>$data["document"],"mobile"=>$data["mobile"],"email"=>$data["email"],"photo"=>base64_encode($data["photo"]));
				}
				$userData = array("code"=>200,"result"=>true, "response"=>$result);
			}
			else {
				$userData = array("code"=>400,"result"=>false, "response"=>"El usuario no está registrado");	
			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}

	function getReferencing($base,$data){
		try {
			$connect = conectDB($base);
			$id_user = trim($data["id_user"]);
			// $id_user = 4;
			// $id_user = "";
			$userData = array();
			$sql = "SELECT document, names, email, mobile, policy, status_redeemed, discount
					FROM referencing
					WHERE id_register = '$id_user'";
			$query = $connect->query($sql);
			if ($query->num_rows > 0) {
				$result = array();
				while ($data = $query->fetch_assoc()) {
					array_push($result, array("document"=>$data["document"],"names"=>$data["names"],"email"=>$data["email"],"mobile"=>$data["mobile"],"policy"=>$data["policy"],"status_redeemed"=>$data["status_redeemed"],"discount"=>$data["discount"]));
				}
				$userData = array("code"=>200, "result"=>true, "response"=>$result);
			}
			else {
				$userData = array("code"=>300, "result"=>false, "response"=>"No tiene referenciados");	

			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}

	function getAllReferenced($base){
		try {
			$connect = conectDB($base);
			$userData = array();
			$sql = "SELECT R.id, R.document, R.names, R.email, R.mobile, R.policy, R.status_redeemed, R.discount, CONCAT(U.names, ' ',U.last_names) as refer_by
					FROM referencing as R INNER JOIN users as U ON R.id_register = U.id_user";
			$query = $connect->query($sql);
			if ($query->num_rows > 0) {
				$result = array();
				while ($data = $query->fetch_assoc()) {
					array_push($result, array("id"=>$data["id"],"document"=>$data["document"],"names"=>$data["names"],"email"=>$data["email"],"mobile"=>$data["mobile"],"policy"=>$data["policy"],"status_redeemed"=>$data["status_redeemed"],"discount"=>$data["discount"],"refer_by"=>$data["refer_by"]));
				}
				$userData = array("code"=>200, "result"=>true, "response"=>$result);
			}
			else {
				$userData = array("code"=>300, "result"=>false, "response"=>"No tiene referenciados");	

			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}

	function createReferencing($base,$data){
		try {
			$connect = conectDB($base);
			$document = trim($data["document"]);
			$email = trim($data["email"]);
			$sql = "SELECT document, names, email, mobile, policy, status_redeemed, discount
					FROM referencing 
					WHERE document = '$document' OR email = '$email'";
			$query = $connect->query($sql);
			if ($query->num_rows == 0) {
				$name = trim($data["name"]);
				$mobile = trim($data["mobile"]);
				$policy = trim($data["policy"]);
				//$id_user = 3;
				$id_user = trim($data["id_user"]);
				$procedure = "INSERT INTO referencing(document, names, email, mobile, policy, id_register, date_entry) 
							VALUES ('$document','$name','$email','$mobile','$policy','$id_user', NOW())";
				//print_r($procedure);
				$newRefer = $connect->query($procedure);
				if ($connect->affected_rows > 0) {
					$userData = array("code"=>200, "result"=>true, "response"=>"Nuevo Referenciado Registrado");
				}
				else {
					$userData = array("code"=>400, "result"=>false, "response"=>"No se pudo crear el referenciado". $connect->affected_rows);	
				}
			}
			else {
				$data_rest = $query->fetch_assoc();
				if ($document == $data_rest["document"]) {
					$userData = array("code"=>300, "result"=>false, "response"=>"El referenciado ya se encuentra registrado");	
				}
				else if ($email == $data_rest["email"]) {
					$userData = array("code"=>300,"result"=>false, "response"=>"Un referenciado ya tiene este correo registrado");	
				}

			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}

	function createUser($base,$data){
		try {
			$connect = conectDB($base);
			$document = trim($data["document"]);
			$email = trim($data["email"]);
			$sql = "SELECT document, email
					FROM users 
					WHERE document = '$document' OR email = '$email'";
			$query = $connect->query($sql);
			if ($query->num_rows == 0) {
				$names = strtoupper(trim($data["names"]));
				$last_names = strtoupper(trim($data["last_names"]));
				$mobile = trim($data["mobile"]);
				$procedure = "INSERT INTO users(names, last_names, document,  mobile, email) 
							VALUES ('$names','$last_names','$document','$mobile','$email')";
				//print_r($procedure);
				$newUser = $connect->query($procedure);
				if ($connect->affected_rows > 0) {
					//$respEmail = "";
					$respEmail = sendEmailSpecial($names,$last_names,$document,$email);
					$userData = array("code"=>200, "result"=>true, "response"=>"Usuario Registrado Exitosamente", "respEmail"=>$respEmail);
				}
				else {
					$userData = array("code"=>400, "result"=>false, "response"=>"No se pudo crear el usuario". $connect->affected_rows);	
				}
			}
			else {
				$data_rest = $query->fetch_assoc();
				if ($document == $data_rest["document"]) {
					$userData = array("code"=>300, "result"=>false, "response"=>"El documento ingresado ya se encuentra registrado");	
				}
				else if ($email == $data_rest["email"]) {
					$userData = array("code"=>300,"result"=>false, "response"=>"El email ingresado ya se encuentra registrado");	
				}
			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}

	function updateUser($base,$data){
		try {
			$connect = conectDB($base);
			/*$document = trim($data["document"]);
			$id_user = trim($data["id_user"]);
			$names = trim($data["names"]);
			$last_names = trim($data["last_names"]);
			$mobile = trim($data["mobile"]);*/
			$id_user = 1;
			$image = trim($data["image"]);
			/*$procedure = "UPDATE users SET names = '$names', last_names = '$last_names', mobile = '$mobile', email = '$email', image = '$image'
						WHERE document = '$document'";*/
			$procedure = "UPDATE users SET photo = $image, image = '$image'
						WHERE id_user = '$id_user'";
			$fl = fopen("sentences.txt", "w+");
			fwrite($fl, $procedure."\n");
			fclose($fl);
			//print_r($procedure);
			$updUser = $connect->query($procedure);
			if ($connect->affected_rows > 0) {
				$userData = array("code"=>200, "result"=>true, "response"=>"Usuario Actualizado Exitosamente");
			}
			else {
				$userData = array("code"=>400, "result"=>false, "response"=>"No se pudo actualizar el usuario". $connect->affected_rows);	
			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}

	function updateStatus($base,$id_refer,$status){
		try {
			$connect = conectDB($base);
			$procedure = "UPDATE referencing SET status_redeemed = '$status'
						WHERE id = '$id_refer'";
			//print_r($procedure);
			$updUser = $connect->query($procedure);
			if ($connect->affected_rows > 0) {
				$userData = array("code"=>200, "result"=>true, "response"=>"Estado actualizado");
			}
			else {
				$userData = array("code"=>300, "result"=>false, "response"=>"No se pudo actualizar el estado". $connect->affected_rows);	
			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}

	function updateDiscount($base,$id_refer,$discount){
		try {
			$connect = conectDB($base);
			$procedure = "UPDATE referencing SET discount = '$discount'
						WHERE id = '$id_refer'";
			//print_r($procedure);
			$updUser = $connect->query($procedure);
			if ($connect->affected_rows > 0) {
				$userData = array("code"=>200, "result"=>true, "response"=>"Descuento actualizado");
			}
			else {
				$userData = array("code"=>300, "result"=>false, "response"=>"No se pudo actualizar el descuento". $connect->affected_rows);	
			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}

	function forgotPassword($base,$data){
		try {
			$connect = conectDB($base);
			$email = trim($data["email"]);
			$sql = "SELECT UPPER(names) as names, UPPER(last_names) as last_names, document 
					FROM users 
					WHERE email = '$email'";
			$query = $connect->query($sql);
			if ($query->num_rows > 0) {
				$data_fetch = $query->fetch_assoc();
				$names = $data_fetch["names"];
				$last_names = $data_fetch["last_names"];
				$document = $data_fetch["document"];
				$respEmail = sendEmailForgot($names,$last_names,$document,$email);
				$userData = array("code"=>200, "result"=>true, "response"=>$respEmail);
			}
			else {
				$userData = array("code"=>300, "result"=>false, "response"=>"El correo indicado no se encuentra registrado en nuestra base de datos");	

			}
			return json_encode($userData);
		} 
		catch(Exception $e){
            return array("code"=>500,"error"=>$e, "is_logged"=>false);
        }
	}


 ?>