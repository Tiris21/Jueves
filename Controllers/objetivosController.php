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
	// var_dump( $asignados->num_rows  ); die;
			return ['vista' => 'ver', 'obj' => $obj, 'c' => $c, 'asignados' => $asignados, 'acciones' => $acciones, 'nombre_usuario' => $nombre_usuario, 'responsables' => $nuevos_responsables];
		}

		public function comentar(){
			if ($_POST) {
				$archivo = null;
				if ($archivo) {
					$archivo = null;
				}
				$this->accion->addComentar($_POST['id_objetivo'], $_POST['comentario'], $archivo);
			}

			header("Location: " . URL . "Objetivos/Ver/" . $_POST['id_objetivo']);
		}

		public function avanzar(){
			if ($_POST) {
				$this->objetivo->avanzar($_POST['id_objetivo'], $_POST['porcentaje_avance'], $_POST['comentario_avance']);
			}

			header("Location: " . URL . "Objetivos/Ver/" . $_POST['id_objetivo']);
		}
	} 


 ?>