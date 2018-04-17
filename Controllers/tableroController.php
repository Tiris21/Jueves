<?php namespace Controllers;
	
	use Models\Objetivo as Objetivo;
	use Models\Usuario as Usuario;
	use Models\Accion as Accion;
	use Models\Correo as Correo;
	use Models\Cita as Cita;

	class tableroController{

		private $objetivo;
		private $usuario;
		private $accion;
		private $mailer;
		private $cita;

		public function __construct(){
			$this->objetivo = new Objetivo();
			$this->usuario = new Usuario();
			$this->accion = new Accion();
			$this->mailer = new Correo();
			$this->cita = new Cita();
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
				$this->objetivo->set('prioridad', $_POST['prioridad']);
				$this->objetivo->set('objetivo_padre', 0);
				
				$id_obj = $this->objetivo->crear();

				// CREAR CITA DE VENCIMIENTO
				$this->cita->set('fecha', $_POST['fecha_vencimiento']);
				$this->cita->set('titulo', $_POST['titulo']);
				$this->cita->set('usuarios', null);
				$this->cita->set('tipo', 'vencimiento');
				$this->cita->set('id_objetivo', $id_obj);
				
				$this->cita->add();
			}	

			header("Location: " . URL . "Tablero");
		}

		public function avanzar(){
			if ($_POST) {
				$this->objetivo->avanzar($_POST['id_objetivo'], $_POST['porcentaje_avance'], $_POST['comentario_avance']);

				// ENVIO DE CORREOS
				if ($_POST['porcentaje_avance'] >= '100') {
					$this->mailer->sendComplete($_POST['id_objetivo']);
				}
			}

			header("Location: " . URL . "Tablero");
		}

		public function comentar(){
			if ($_POST) {
				$file_name = '';
				$archivo = $_FILES['archivo'];
				if ($archivo) {
					
					if ($archivo['size'] < 10000000){

						$file_name = $archivo['name'];
						$file_name = str_replace(' ', '', $file_name);
						$file_name = str_replace('ñ', 'n', $file_name);
						$file_name = str_replace('Ñ', 'N', $file_name);

						$add = "Archivos/$file_name";
						
						move_uploaded_file ($archivo['tmp_name'], $add);
					}
				}

				$this->accion->addComentar($_POST['id_objetivo'], $_POST['comentario'], $file_name);
				
				if (isset($_POST['equipo'])) {
					header("Location: " . URL . "Tablero/Equipo");
				}

				if (isset($_POST['tablero_ver'])) {
					header("Location: " . URL . "Equipo/Tablero/" . $_POST['tablero_ver']);
				}
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
				$o = $this->objetivo->viewID($_POST['id_objetivo']);
				$this->objetivo->set('prioridad', $o['prioridad']);

				$ids = $this->objetivo->asignar($_POST['id_objetivo'], $_POST['responsable'], $_POST['comentario_asignacion']);

				// AGREGAR CITAS DE VENCIMIENTO
				$this->cita->addVencimientoAsignados($_POST['titulo'], $_POST['fecha_vencimiento'], $ids, $_POST['responsable']);

				// ENVIO DE CORREOS
				$this->mailer->sendAsignados($ids);

				if (isset($_POST['de_ver'])) {
					header("Location: " . URL . "Objetivos/ver/" . $_POST['de_ver']);
				}
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
				echo 'json_encode(["responseText"=>"<form action="wfwdf/editwdfar/" method="POST">"])';
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
			// if (isset($_SESSION['login'])) { # el if solo es para que no marque error en el login porque es la pantalla principal (HOME)
				$objetivos = $this->objetivo->listarObjetivosDeEquipo($_SESSION['id_usuario']);
			// }else{
			// 	$mis_objetivos = '';
			// 	$mi_equipo = '';
			// }

			return ['vista' => 'equipo', 'objetivos' => $objetivos];
		}


	} 


 ?>