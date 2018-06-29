<?php namespace Models;

	class Correo{

		private $obj;
		private $user;
		private $accion;

		public function __construct(){
			$this->obj = new Objetivo();
			$this->user = new Usuario();
			$this->accion = new Accion();
		}


		public function sendAsignados($objetivos){
			foreach ($objetivos as $id_o) {
				$obje = $this->obj->viewID($id_o);
				$us = $this->user->viewID($obje['responsable']);

				$destinatario['correo'] = $us['correo'];
				$destinatario['nombre'] = $us['nombre'];

				switch ($obje['prioridad']) {
					case 'alta':
						$usuario_padre = $us['usuario_jefe'];
						while ($usuario_padre != 0) {
							$us_p = $this->user->viewID($usuario_padre);
							$copiados[$us_p['nombre']] = $us_p['correo'];
							$usuario_padre = $us_p['usuario_jefe'];
						}
					break;
					case 'media':
						$us_p = $this->user->viewID($us['usuario_jefe']);
						$copiados[$us_p['nombre']] = $us_p['correo'];

					break;
					case 'baja':
						$copiados = null;
					break;
				}

				enviarCorreo($destinatario, $copiados, 'asignado', $obje['id_objetivo'], $obje['titulo']);
			}

		}

		public function sendComment($id_obj, $user_comment){

			$obje = $this->obj->viewID($id_obj);
			if ($user_comment != $obje['responsable']) {
				$us = $this->user->viewID($obje['responsable']);
				$destinatario['correo'] = $us['correo'];
				$destinatario['nombre'] = $us['nombre'];
			}

			if ($obje['objetivo_padre'] > 0) {

				$obj_padre = $this->obj->viewID($obje['objetivo_padre']);
				$us = $this->user->viewID($obj_padre['responsable']);
				
				if (isset($destinatario)) {
					$copiados[$us['nombre']] = $us['correo'];
				}else{	
					$destinatario['correo'] = $us['correo'];
					$destinatario['nombre'] = $us['nombre'];
				}
				
				switch ($obje['prioridad']) {
					case 'alta':
						//LISTOOOO
						while ($obj_padre['objetivo_padre'] > 0) {
							$obj_padre = $this->obj->viewID( $obj_padre['objetivo_padre'] );
							$us = $this->user->viewID($obj_padre['responsable']);
							$copiados[$us['nombre']] = $us['correo'];
						}
					break;
					case 'media':
						//SOLO 3 VECES
						$x = 1;
						while ($obj_padre['objetivo_padre'] > 0 && $x <= 3) {
							$obj_padre = $this->obj->viewID( $obj_padre['objetivo_padre'] );
							$us = $this->user->viewID($obj_padre['responsable']);
							$copiados[$us['nombre']] = $us['correo'];
							$x++;
						}
					break;
					case 'baja':
						$us = $this->user->viewID($obj_padre['responsable']);
						$copiados[$us['nombre']] = $us['correo'];
						$usuario_padre = $us['usuario_jefe'];
					break;
				}
			
				enviarCorreo($destinatario, $copiados, 'comentario', $obje['id_objetivo'], $obje['titulo']);
			}// else no tiene objetivopadre
		}

		public function sendComplete($id_o){
				$obje = $this->obj->viewID($id_o);
				$us = $this->user->viewID($obje['responsable']);

				$destinatario['correo'] = $us['correo'];
				$destinatario['nombre'] = $us['nombre'];

				switch ($obje['prioridad']) {
					case 'alta':
						$usuario_padre = $us['usuario_jefe'];
						while ($usuario_padre != 0) {
							$us_p = $this->user->viewID($usuario_padre);
							$copiados[$us_p['nombre']] = $us_p['correo'];
							$usuario_padre = $us_p['usuario_jefe'];
						}
					break;
					case 'media':
						$us_p = $this->user->viewID($us['usuario_jefe']);
						$copiados[$us_p['nombre']] = $us_p['correo'];

					break;
					case 'baja':
						$copiados = null;
					break;
				}

				enviarCorreo($destinatario, $copiados, 'completo', $obje['id_objetivo'], $obje['titulo']);

		}




		public function enviarCorreoAsignacion(){
			// enviarCorreo($destinatario, $copiados, $tipo, $objetivo, $aux = null){
			$destinatario['correo'] = 'angel.alvarez@vitrohogar.com.mx';
			$destinatario['nombre'] = 'Angel Alvarez';
			// $copiados['Salvador Cornejo'] = 'salvador.cornejo@vitrohogar.com.mx';
			// $copiados['Pancho'] = 'panchin.lopez@vitro.com';
			// var_dump($copiados); die;
			
			// enviarCorreo($destinatario, $copiados, 'vencido', 36, 'titulo de un objetivo');
			// enviarCorreo($destinatario, $copiados, 'completo', 36, 'titulo de un objetivo');
			// enviarCorreo($destinatario, $copiados, 'casi', 36, ['titulo de un objetivo', 3]);
			// enviarCorreo($destinatario, $copiados, 'asignado', 36, 'titulo de un objetivo');

			header("Location: " . URL . "Objetivos/Ver/32");
		}
		

	}
 ?>