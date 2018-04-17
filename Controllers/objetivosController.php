<?php namespace Controllers;
	
	use Models\Objetivo as Objetivo;
	use Models\Usuario as Usuario;
	use Models\Accion as Accion;

	class objetivosController{

		private $objetivo;
		private $accion;
		private $usuario;

		public function __construct(){
			$this->objetivo = new Objetivo();
			$this->accion = new Accion();
			$this->usuario = new Usuario();
		}

		public function ver($id_obj){
			$obj = $this->objetivo->viewId($id_obj);
			$c = getColorPorPorcentaje($obj['avance']);
			
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
			}
	// var_dump( $obj  ); die;
			return ['vista' => 'ver', 'obj' => $obj, 'c' => $c, 'asignados' => $asignados, 'acciones' => $acciones, 'nombre_usuario' => $nombre_usuario, 'responsables' => $nuevos_responsables, 'mi_equipo' => $mi_equipo];
		}

		public function comentar(){
			if ($_POST) {

			// var_dump($_POST['archivo']); die;
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
				$this->accion->addComentar($_POST['id_objetivo'], $_POST['comentario'], $file_name);
			}

			header("Location: " . URL . "Objetivos/Ver/" . $_POST['id_objetivo']);
		}


		public function avanzar(){
			if ($_POST) {
				$this->objetivo->avanzar($_POST['id_objetivo'], $_POST['porcentaje_avance'], $_POST['comentario_avance']);
			}

			header("Location: " . URL . "Objetivos/Ver/" . $_POST['id_objetivo']);
		}


		public function descargar($archivo){
			header("Content-disposition: attachment; filename=Archivos/".$archivo);
			readfile("Archivos/".$archivo);
		}


	} 


 ?>