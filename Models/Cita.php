<?php namespace Models;

	class Cita{
		private $id;
		private $fecha;
		private $titulo;
		private $estatus;
		private $usuarios;
		private $id_objetivo;

		private $con;

		public function __construct(){
			$this->con = new Conexion();
		}

		public function set($atributo, $contenido){
			$this->$atributo = $contenido;
		}

		public function get($atributo){
			return $this->$atributo;
		}

		public function listarMisCitas($usuario){
			$query = 'SELECT c.*, u.id_usuario FROM cita c JOIN cita_usuario u ON c.id_cita = u.id_cita WHERE c.estatus <> "baja" AND u.id_usuario = ' . $usuario;
			return $this->con->consultaRetorno($query);
		}


		public function add(){
			$query = "INSERT INTO cita SET fecha = '{$this->fecha}', titulo = '{$this->titulo}', id_objetivo = '{$this->id_objetivo}', estatus = 'activo';";
			$id_cita = $this->con->consultaSimpleID($query);

			$query = "INSERT INTO cita_usuario SET id_cita = '{$id_cita}', id_usuario = " . $_SESSION['id_usuario'];
			$this->con->consultaSimple($query);

			foreach ($this->usuarios as $us) {
				$query = "INSERT INTO cita_usuario SET id_cita = '{$id_cita}', id_usuario = " . $us;
				$this->con->consultaSimple($query);
			}
		}


		// public function viewId($id){
		// 	$query = 'SELECT e.*, s.nombre FROM estudiantes e INNER JOIN secciones s ON e.id_seccion = s.id WHERE id_usuario = '.$id;
		// 	$datos = $this->con->consultaRetorno($query);
		// 	$row = mysqli_fetch_assoc($datos);
		// 	return $row;
		// }
		

	}
 ?>