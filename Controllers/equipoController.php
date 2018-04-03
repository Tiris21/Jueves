<?php namespace Controllers;
	
	use Models\Usuario as Usuario;
	use Models\Objetivo as Objetivo;

	class equipoController{

		private $usuario;
		private $objetivo;

		public function __construct(){
			$this->usuario = new Usuario();
			$this->objetivo = new Objetivo();
		}

		public function index(){
			$mi_equipo = $this->usuario->listarMiEquipo($_SESSION['id_usuario']);

			foreach ($mi_equipo as $es) {
				$equipo_sub = $this->usuario->listarMiEquipo($es['id_usuario']);
				if ($equipo_sub->num_rows > 0) {
					$tienen_equipo[ $es['id_usuario'] ] = true;
				}else{
					$tienen_equipo[ $es['id_usuario'] ] = false;
				}
			}

			return ['vista' => 'index', 'mi_equipo' => $mi_equipo, 'tienen_equipo' => $tienen_equipo];
		}


		public function ver($id_usr){
			$usr = $this->usuario->viewId($id_usr);
			$equipo_subequipo = $this->usuario->listarMiEquipo($id_usr);

			// if ($equipo_subequipo) {
			// 	$tienen_equipo = '';
			// }
			foreach ($equipo_subequipo as $es) {
				$equipo_sub = $this->usuario->listarMiEquipo($es['id_usuario']);
				if ($equipo_sub->num_rows > 0) {
					$tienen_equipo[ $es['id_usuario'] ] = true;
				}else{
					$tienen_equipo[ $es['id_usuario'] ] = false;
				}
			}

			// la variable puede_ver indica si el equipo que se quiere ver no esta en un nivel mas alto del usuario loggeado
			$puede_ver = $this->usuario->permisoJerarquico($_SESSION['id_usuario'], $id_usr);
			if ( is_null($puede_ver)) 
				$puede_ver = 'carefully';

			return ['vista' => 'ver_equipo', 'usr' => $usr, 'equipo_subequipo' => $equipo_subequipo, 'tienen_equipo' => $tienen_equipo, 'puede_ver' => $puede_ver];
		}


		public function tablero($id_usr){
			$usr = $this->usuario->viewId($id_usr);
			$objetivos_usuario = $this->objetivo->listarMisObjetivos($id_usr);

			// la variable puede_ver indica si el usuario loggeado tienen permiso de ver el tablero solicitado 
			$puede_ver = $this->usuario->permisoJerarquico($_SESSION['id_usuario'], $id_usr);
			if ( is_null($puede_ver)) 
				$puede_ver = 'carefully';

			return ['vista' => 'ver_tablero', 'objetivos_usuario' => $objetivos_usuario, 'usr' => $usr, 'puede_ver' => $puede_ver];
		}



	} 


 ?>