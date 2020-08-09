<?php 
	
	function sendEmailSpecial($names,$last_names,$document,$email){

		// require 'PHPMailerAutoload.php';
		require_once('PHPMailer/PHPMailerAutoload.php');


		$mail = new PHPMailer;
		// print_r($email);

		$name_complete = $last_names." ".$names;
		$message = "<b>Sr(a). $last_names, $names</b><br>
					<br>
					Bienvenido a Total SegurosMobile<br><br>
					Gracias por registrarse en nuestro sistema<br>
					Para realizar el ingreso a la aplicación a continuación relacionamos sus credenciales:<br>
					Usuario: <b>$email</b><br>
					Clave: <b>$document</b>
					<br><br>
					Total SegurosMobile";

		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		// $mail->Host = 'mail.clickquero.com';  // Specify main and backup SMTP servers
		$mail->Host = 'kadri.dongee.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'sendermail@clickqueros.com';                 // SMTP username
		$mail->Password = 'Clickque2020@';                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to

		$mail->setFrom('sendermail@clickqueros.com', 'Mailer');
		$mail->addAddress($email, $name_complete);
		$mail->isHTML(true);

		$mail->Subject = 'Credenciales de Ingreso';
		$mail->Body = $message;

		if(!$mail->send()) {
		    // echo 'Error, mensaje no enviado';
		    $statusMessage = 'Error del mensaje: ' . $mail->ErrorInfo;
		} else {
		    $statusMessage = 'El mensaje se ha enviado correctamente';
		    
		}

		return $statusMessage;
	}
	
	function sendEmailForgot($names,$last_names,$document,$email){

		// require 'PHPMailerAutoload.php';
		require_once('PHPMailer/PHPMailerAutoload.php');

		$mail = new PHPMailer;
		// print_r($email);

		$name_complete = $last_names." ".$names;
		$message = "<b>Sr(a). $last_names, $names</b><br>
					<br>
					En el presente correo relacionaremos las credenciales para acceder a la aplicación:<br>
					Usuario: <b>$email</b><br>
					Clave: <b>$document</b>
					<br><br>
					Total SegurosMobile";

		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		// $mail->Host = 'mail.clickquero.com';  // Specify main and backup SMTP servers
		$mail->Host = 'kadri.dongee.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'sendermail@clickqueros.com';                 // SMTP username
		$mail->Password = 'Clickque2020@';                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to

		$mail->setFrom('sendermail@clickqueros.com', 'Total Seguros Mobile');
		$mail->addAddress($email, $name_complete);
		$mail->isHTML(true);

		$mail->Subject = 'Solicitud para recuperar de Credenciales';
		$mail->Body = $message;

		if(!$mail->send()) {
		    // echo 'Error, mensaje no enviado';
		    $statusMessage = 'Error del mensaje: ' . $mail->ErrorInfo;
		} else {
		    $statusMessage = 'Por favor revise su correo electronico en donde recibirá la información para ingresar a la aplicación.';
		    
		}

		return $statusMessage;
	}

 ?>