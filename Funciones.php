<?php 

	function formatearFecha($fecha){
		$meses_formato_fecha = array("barrio", "Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
		$fecha_formateada = date('d/' , strtotime($fecha));
		$fecha_formateada .= $meses_formato_fecha[date('n' , strtotime($fecha))];
		$fecha_formateada .= date('/Y' , strtotime($fecha));
		return $fecha_formateada;
	}

	function formatearFechaHora($fecha){
		$meses_formato_fecha = array("barrio", "Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
		$fecha_formateada = date('d/' , strtotime($fecha));
		$fecha_formateada .= $meses_formato_fecha [date('n' , strtotime($fecha)) ];
		$fecha_formateada .= date('/Y H:i' , strtotime($fecha));
		return $fecha_formateada; // M = Mes en tres letras
	}

	function difDiasAHoy($fecha){
		$fecha1 = strtotime($fecha);
		$hoy = strtotime(date("Y-m-d"));
		return round(($fecha1 - $hoy) / 86400);
	}

	function difDias($fecha1, $fecha2){
		$fecha_1 = strtotime($fecha1);
		$fecha_2 = strtotime($fecha2);
		return round(($fecha_2 - $fecha_1) / 86400);
	}

	function getColorPorPorcentaje($avance, $dias, $fecha_ven){
		$dpv = difDiasAHoy($fecha_ven);
		$porcentaje_avance_tiempo = (($dias-$dpv) * 100) / $dias;

		if ($porcentaje_avance_tiempo <= 15) { // de 0 a 15 -> Iniciando el objetivo
			$color = 'success';			
		
		} else if( $porcentaje_avance_tiempo >= 90){ // > 90 -> Venciendo el objetivo
			if ($avance < 95) {
				$color = 'danger';
			}else if($avance < 100){
				$color = 'warning';
			}else{
				$color = 'success';
			}

		}else{
			if ($avance >= $porcentaje_avance_tiempo) { // del 15.1 al 90 -> porcentaje de avance
				$color = 'success';
			}else if ($avance >= ($porcentaje_avance_tiempo - 10) ) {
				$color = 'warning';
			}else {
				$color = 'danger';
			}
		}
// var_dump($porcentaje_avance_tiempo); die;
		return $color;
	}

	function enviarCorreo($destinatario, $copiados, $tipo, $objetivo, $aux = null){

			$mailer_ruta = ROOT . "Config" . DS . "lib" . DS . "PHPMailer-master" . DS . "class.phpmailer.php";
			require_once $mailer_ruta;

			$mailer_ruta = ROOT . "Config" . DS . "lib" . DS . "PHPMailer-master" . DS . "class.smtp.php";
			require_once $mailer_ruta;

			$mail = new \PHPMailer(true); 

			try {
			    //Server settings
			    $mail->SMTPDebug = 2;                           	// Enable verbose debug output
			    $mail->isSMTP();                               		// Set mailer to use SMTP
			    $mail->Host = 'smtp.1and1.mx';  					// Specify main and backup SMTP servers
			    $mail->SMTPAuth = true;                            	// Enable SMTP authentication
			    $mail->Username = 'vhaproject@vitrohogar.com.mx';  	// SMTP username
			    $mail->Password = 'vhprjct0';					// SMTP password
			    $mail->SMTPSecure = 'tls';        					// Enable TLS encryption, `ssl` also accepted
			    $mail->Port = 25;                    				// TCP port to connect to

			    //Recipients
			    $mail->setFrom('vhaproject@vitrohogar.com.mx', 'VHA Project');
			    
			    $mail->addAddress($destinatario['correo'], $destinatario['nombre']);    	// Add a recipient
			    
			    if (is_array($copiados)) {
				    foreach ($copiados as $nombre => $correo) {
				    	$mail->addCC($correo, $nombre);
				    }
			    }

			    //Content
			    $mail->isHTML(true);    // Set email format to HTML

			    switch ($tipo) {
			    	case 'vencido':
			    		$mail->Subject = 'Objetivo Vencido';
					    $mail->Body    = '<h2> Hola ' . limpiarCadena($destinatario['nombre']) . '! </h2> <br> <h3> Usted tiene un objetivo vencido con ' . limpiarCadena($aux) . ' d&iacute;as de atraso </h3> <h3> Entra al siguiente link para ir al portal de VHA Project y ver los detalles de la situaci&oacute;n </h3> <a href="'.URL.'Objetivos/ver/'.$objetivo.'"> '.URL.'Objetivos/ver/'.$objetivo.' </a>';
			    	break;
			    	
			    	case 'completo':
			    		$mail->Subject = 'Objetivo Completado';
					    $mail->Body    = '<h2> Hola ' . limpiarCadena($destinatario['nombre']) . '! </h2> <br> 
							    <h3>En Hora Buena!! Haz completado tu objetivo  <i> "'.limpiarCadena($aux).'" </i> </h3>
							    <h3> Entra al siguiente link para ir al portal de VHA Project y ver los detalles de la situaci&oacute;n </h3> 
							    <a href="'.URL.'Objetivos/ver/'.$objetivo.'"> '.URL.'Objetivos/ver/'.$objetivo.' </a>';
			    	break;
			    	
			    	case 'casi':
			    		$mail->Subject = 'Objetivo Proximo de Vencer';
					    $mail->Body    = '<h2> Hola ' . limpiarCadena($destinatario['nombre']) . '! </h2> <br> 
							    <h3> Tu objetivo <i>"'.limpiarCadena($aux[0]).'"</i> vence en '.$aux[1].' d&iacute;as  </h3>
							    <h3>Entra al siguiente link para ir al portal de VHA Project y ver los detalles de la situaci&oacute;n </h3> 
							    <a href="'.URL.'Objetivos/ver/'.$objetivo.'"> '.URL.'Objetivos/ver/'.$objetivo.' </a>';
			    	break;
			    	
			    	case 'asignado':
			    		$mail->Subject = 'Objetivo Asignado';
					    $mail->Body    = '<h2> Hola ' . limpiarCadena($destinatario['nombre']) . '! </h2> <br> 
							    <h3>Se te ha asignado un nuevo objetivo <i>"'.limpiarCadena($aux).'"</i>  </h3>
							    <h3>Entra al siguiente link para ir al portal de VHA Project y ver los detalles de la situaci&oacute;n </h3> 
							    <a href="'.URL.'Objetivos/ver/'.$objetivo.'"> '.URL.'Objetivos/ver/'.$objetivo.' </a>';
			    	break;	

			    	case 'comentario':
			    		$mail->Subject = 'Han comentado un objetivo';
					    $mail->Body    = '<h2> Hola ' . limpiarCadena($destinatario['nombre']) . '! </h2> <br> 
							    <h3>Se ha agregado un nuevo comentario en <i>"'.limpiarCadena($aux).'"</i>  </h3>
							    <h3>Entra al siguiente link para ir al portal de VHA Project y ver los detalles de la situaci&oacute;n </h3> 
							    <a href="'.URL.'Objetivos/ver/'.$objetivo.'"> '.URL.'Objetivos/ver/'.$objetivo.' </a>';
			    	break;
			    	
			    	default:
			    		$mail->Subject = 'Here is the subject';
					    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			    	break;
			    }

			    $mail->send();
			    // echo 'Message has been sent';
			} catch (Exception $e) {
			    // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo; 
			}
		}

	function limpiarCadena($string)
	{
	    $string = trim($string);
	    $string = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('&aacute;', '&aacute;', '&aacute;', '&aacute;', '&aacute;', '&Aacute;', '&Aacute;', '&Aacute;', '&Aacute;'),
	        $string
	    );
	    $string = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('&eacute;', '&eacute;', '&eacute;', '&eacute;', '&Eacute;', '&Eacute;', '&Eacute;', '&Eacute;'),
	        $string
	    );
	    $string = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('&iacute;', '&iacute;', '&iacute;', '&iacute;', '&Iacute;', '&Iacute;', '&Iacute;', '&Iacute;'),
	        $string
	    );
	    $string = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('&oacute;', '&oacute;', '&oacute;', '&oacute;', '&Oacute;', '&Oacute;', '&Oacute;', '&Oacute;'),
	        $string
	    );
	    $string = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('&uacute;', '&uacute;', '&uacute;', '&uacute;', '&Uacute;', '&Uacute;', '&Uacute;', '&Uacute;'),
	        $string
	    );
	    $string = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('&ntilde;', '&Ntilde;', 'c', 'C',),
	        $string
	    );
	    //Esta parte se encarga de eliminar cualquier caracter extraño
	    // $string = str_replace(
	    //     array("\", "¨", "º", "-", "~",
	    //          "#", "@", "|", "!", """,
	    //          "·", "$", "%", "&", "/",
	    //          "(", ")", "?", "'", "¡",
	    //          "¿", "[", "^", "<code>", "]",
	    //          "+", "}", "{", "¨", "´",
	    //          ">", "< ", ";", ",", ":",
	    //          ".", " "),
	    //     '',
	    //     $string
	    // );

	    return $string;
	}

 ?>