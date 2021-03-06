<?php namespace Controllers;
	
	use Models\Objetivo as Objetivo;
	use Models\Usuario as Usuario;
	use Models\Accion as Accion;
	use Models\Correo as Correo;

	class objetivosController{

		private $accion;
		private $objetivo;
		private $mailer;
		private $usuario;

		public function __construct(){
			$this->objetivo = new Objetivo();
			$this->accion = new Accion();
			$this->usuario = new Usuario();
			$this->mailer = new Correo();
		}

		public function ver($id_obj){
			$obj = $this->objetivo->viewId($id_obj);

			$c = getColorPorPorcentaje($obj['avance'], $obj['dias'],  $obj['fecha_vencimiento'] );

			$asignados = $this->objetivo->listarSubobjetivos($id_obj);
			$acciones = $this->accion->listarPorObjetivo($id_obj);
			$mi_equipo = $this->usuario->listarMiEquipo($_SESSION['id_usuario']);

			$nombre_usuario = '';
			$nuevos_responsables = '';
			foreach ($acciones as $accion) {
				if ($accion['clase'] == 'apropiar') {
					$usuario = $this->objetivo->viewId($accion['aux1']);
					$nombre_usuario = $usuario['nombre'];
				}
				if ($accion['clase'] == 'asignar') {
					$nuevos_responsables = $this->accion->usuariosResposablesAlAsignar($id_obj);
				}
				if ($accion['clase'] == 'comentar') {
					$usuario = $this->usuario->viewId($accion['id_usuario']);
					$comentadores[] = $usuario['nombre'];
				}
			}

			if ( !isset($comentadores) )
				$comentadores = '';

			$objetivo_padre = $this->objetivo->viewId($obj['objetivo_padre']);
			
			// la variable puede_ver indica si el equipo que se quiere ver no esta en un nivel mas alto del usuario loggeado
			$puede_ver = $this->usuario->permisoJerarquico($_SESSION['id_usuario'], $obj['responsable']);
			if ( is_null($puede_ver)) 
				$puede_ver = 'nel';

			return ['vista' => 'ver', 'obj' => $obj, 'c' => $c, 'asignados' => $asignados, 'acciones' => $acciones, 'nombre_usuario' => $nombre_usuario, 'responsables' => $nuevos_responsables, 'mi_equipo' => $mi_equipo, 'puede_ver' => $puede_ver, 'objetivo_padre' => $objetivo_padre, 'comentadores' => $comentadores];
		}

		public function comentar(){
			if ($_POST) {

				$file_name = '';
				$archivo = $_FILES['archivo'];
				if ($archivo) {

					if ($archivo['size'] < 10000000){

						// if (!($_FILES[uploadedfile][type] =="image/pjpeg" OR $_FILES[uploadedfile][type] =="image/gif")) {
						// 	$msg=$msg." Tu archivo tiene que ser JPG o GIF. Otros archivos no son permitidos<BR>";
						// 	$uploadedfileload="false";
						// }

						$file_name = $archivo['name'];
						$file_name = str_replace(' ', '', $file_name);
						$file_name = str_replace('ñ', 'n', $file_name);
						$file_name = str_replace('Ñ', 'N', $file_name);
						// $file_name = trim($file_name);
						$add = "Archivos/$file_name";
						
						move_uploaded_file ($archivo['tmp_name'], $add);
						// if(move_uploaded_file ($archivo['tmp_name'], $add)){
						
					}

				}
				// ACCION PARA BITACORA
				$this->accion->addComentar($_POST['id_objetivo'], $_POST['comentario'], $file_name);

				// ENVIO DE CORREOS
				$this->mailer->sendComment($_POST['id_objetivo'], $_SESSION['id_usuario']);
			}

			header("Location: " . URL . "Objetivos/Ver/" . $_POST['id_objetivo']);
		}


		public function avanzar(){
			if ($_POST) {
				$this->objetivo->avanzar($_POST['id_objetivo'], $_POST['porcentaje_avance'], $_POST['comentario_avance']);
			}

			// ENVIO DE CORREOS
			if ($_POST['porcentaje_avance'] >= '100') {
				$this->mailer->sendComplete($_POST['id_objetivo']);
			}

			header("Location: " . URL . "Objetivos/Ver/" . $_POST['id_objetivo']);
		}


		public function descargar($archivo){
			header("Content-disposition: attachment; filename=Archivos/".$archivo);
			readfile("Archivos/".$archivo);
		}


		// public function index(){
		// 	return ['vista' => 'index'];
		// }


	} 


 ?>