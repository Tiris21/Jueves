<?php namespace Controllers;
	
	use Models\Objetivo as Objetivo;
	use Models\Usuario as Usuario;

	class tableroController{

		private $objetivo;
		private $usuario;

		public function __construct(){
			$this->objetivo = new Objetivo();
			$this->usuario = new Usuario();
		}

		public function index(){
			if (isset($_SESSION['login'])) { # el if solo es para que no marque error en el login porque es la pantalla principal (HOME)
				$mis_objetivos = $this->objetivo->listarMisObjetivos($_SESSION['id_usuario']);
				$mi_equipo = $this->usuario->listarMiEquipo($_SESSION['id_usuario']);
			}else{
				$mis_objetivos = '';
				$mi_equipo = '';
			}

			return ['mis_objetivos' => $mis_objetivos, 'mi_equipo' => $mi_equipo, 'vista' => 'index'];
		}

		public function crear(){
			if ($_POST) {
				$this->objetivo->set('titulo', $_POST['titulo']);
				$this->objetivo->set('descripcion', $_POST['descripcion']);
				$this->objetivo->set('dias', $_POST['dias']);
				$this->objetivo->set('fecha_asignacion', $_POST['fecha_inicio']);
				$this->objetivo->set('fecha_vencimiento', $_POST['fecha_vencimiento']);
				$this->objetivo->set('responsable', $_SESSION['id_usuario']);
				$this->objetivo->set('asignador', $_SESSION['id_usuario']);
				$this->objetivo->set('objetivo_padre', 0);
				$this->objetivo->add();
			}	

			header("Location: " . URL . "Tablero");
		}

		public function avanzar(){
			if ($_POST) {
				$this->objetivo->avanzar($_POST['id_objetivo'], $_POST['porcentaje_avance']);
			}

			header("Location: " . URL . "Tablero");
		}

		public function asignar(){
			if ($_POST) {
				$this->objetivo->set('titulo', $_POST['titulo']);
				$this->objetivo->set('descripcion', $_POST['descripcion']);
				$this->objetivo->set('dias', $_POST['dias']);
				$this->objetivo->set('fecha_asignacion', $_POST['fecha_inicio']);
				$this->objetivo->set('fecha_vencimiento', $_POST['fecha_vencimiento']);
				$this->objetivo->set('asignador', $_SESSION['id_usuario']);
				$this->objetivo->set('objetivo_padre', $_POST['id_objetivo']);

				$this->objetivo->asignar($_POST['id_objetivo'], $_POST['responsable']);
			}

			header("Location: " . URL . "Tablero");
		}

		public function ajaxDetalleObjetivo(){
			if ($_POST) {
				$obj = $this->objetivo->viewID($_POST['id_obj']);
				echo "<h3>".$obj['titulo']."</h3>
		              <p>".$obj['descripcion']."</p>
		              <p>Responsable: ".$obj['nombre']."</p>
		              <p>Fechas: del ".formatearFecha($obj['fecha_asignacion'])." al ".formatearFecha($obj['fecha_vencimiento'])."</p>
		              <p>Porcentaje de avance: ".$obj['avance']."%</p>";
			}else{
				echo 'json_encode(["responseText"=>"<form action="yates/editar/" method="POST">"])';
			}
		}

		public function ajaxObjetivo(){
			if ($_POST) {
				$obj = $this->objetivo->viewID($_POST['id_obj']);
				echo json_encode([	"titulo" => $obj['titulo'], 
									"descripcion" => $obj['descripcion'], 
									"fecha_asignacion" => $obj['fecha_asignacion'], 
									"fecha_vencimiento" => $obj['fecha_vencimiento'], 
									"dias" => $obj['dias'] 
								]);
			}else{
				echo json_encode(["responseText" => "nanay"]);
			}
		}

		public function equipo(){
			$datos = '';
			return $datos;
		}
	} 


 ?>