<?php namespace Controllers;
	
	use Models\Usuario as Usuario;

	class equipoController{

		private $usuario;

		public function __construct(){
			$this->usuario = new Usuario();
		}

		public function index(){
			$mi_equipo = $this->usuario->listarMiEquipo($_SESSION['id_usuario']);
			return ['vista' => 'index', 'mi_equipo' => $mi_equipo];
		}


		public function ver($id_usr){
			$usr = $this->usuario->viewId($id_usr);
			
			$equipo_subequipo = $this->usuario->listarMiEquipo($id_usr);
	// var_dump( $asignados->num_rows  ); die;
			foreach ($equipo_subequipo as $es) {
				$equipo_sub = $this->usuario->listarMiEquipo($es['id_usuario']);
				if ($equipo_sub->num_rows > 0) {
					$tienen_equipo[ $es['id_usuario'] ] = true;
				}else{
					$tienen_equipo[ $es['id_usuario'] ] = false;
				}
			}
	// var_dump($tienen_equipo); die;
			return ['vista' => 'ver_equipo', 'usr' => $usr, 'equipo_subequipo' => $equipo_subequipo, 'tienen_equipo' => $tienen_equipo];
		}



		public function vesfr($id_obj){
			$obj = $this->objetivo->viewId($id_obj);

			// $c = getColorPorPorcentaje($obj['avance']);
			
			// $asignados = $this->objetivo->listarSubobjetivos($id_obj);
			// $acciones = $this->accion->listarPorObjetivo($id_obj);

			// $nombre_usuario = '';
			// $nuevos_responsables = '';
			// foreach ($acciones as $accion) {
			// 	if ($accion['clase'] == 'apropiar') {
			// 		$usuario = $this->objetivo->viewId($accion['aux1']);
			// 		$nombre_usuario = $usuario['nombre'];
			// 	}
			// 	if ($accion['clase'] == 'asignar') {
			// 		$nuevos_responsables = $this->accion->usuariosResposablesAlAsignar($id_obj);
			// 	}
			// }
	// var_dump( $asignados->num_rows  ); die;
			return ['vista' => 'ver', 'obj' => $obj, 'c' => $c, 'asignados' => $asignados, 'acciones' => $acciones, 'nombre_usuario' => $nombre_usuario, 'responsables' => $nuevos_responsables];
		}

	} 


 ?>