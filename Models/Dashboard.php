<?php namespace Models;

	class Dashboard{

		private $con;

		public function __construct(){
			$this->con = new Conexion();
		}

		public function getCitasNuevas($id_usr){
			$query = '	SELECT COUNT(*) AS total
						FROM cita c
						JOIN cita_usuario cu ON c.id_cita = cu.id_cita
						JOIN usuario u ON u.id_usuario = cu.id_usuario
						WHERE c.tipo = "junta"
						AND c.estatus = "activo"
						AND c.fecha > u.last_login
						AND cu.id_usuario = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['total'];
		}

		public function getAvancesNuevos($id_usr){
			$query = '	SELECT COUNT(*) AS total
						FROM accion a
						JOIN objetivo o ON o.id_objetivo = a.id_objetivo
						JOIN usuario u ON u.id_usuario = o.responsable
						WHERE a.clase = "avanzar"
						AND o.estatus = "activo"
						AND a.fecha_creacion > u.last_login
						AND u.id_usuario = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['total'];
		}

		public function getComentariosNuevos($id_usr){
			$query = '	SELECT COUNT(*) AS total
						FROM accion a
						JOIN objetivo o ON o.id_objetivo = a.id_objetivo
						JOIN usuario u ON u.id_usuario = o.responsable
						WHERE a.clase = "comentar"
						AND o.estatus = "activo"
						AND a.fecha_creacion > u.last_login
						AND u.id_usuario = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['total'];
		}

		public function getAsignacionesNuevas($id_usr){
			$query = '	SELECT COUNT(*) AS total
						FROM accion a
						JOIN usuario u ON u.id_usuario = a.id_usuario
						WHERE a.clase = "apropiar"
						AND a.fecha_creacion > u.last_login
						AND u.id_usuario = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['total'];
		}

		public function getDatosGrafica($id_usr){
			return [ $this->getDatosGraficaRojo($id_usr), $this->getDatosGraficaAmarillo($id_usr), $this->getDatosGraficaVerde($id_usr) ];
		}

		public function getDatosGraficaRojo($id_usr){
			$query = 'SELECT COUNT(*) AS rojo FROM objetivo WHERE estatus = "activo" AND avance < 30 AND responsable = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['rojo'];
		}

		public function getDatosGraficaAmarillo($id_usr){
			$query = 'SELECT COUNT(*) AS amarillo FROM objetivo WHERE estatus = "activo" AND avance > 31 AND avance < 70 AND responsable = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['amarillo'];
		}

		public function getDatosGraficaVerde($id_usr){
			$query = 'SELECT COUNT(*) AS verde FROM objetivo WHERE estatus = "activo" AND avance >= 70 AND responsable = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['verde'];
		}

		public function getProximasCitas($id_usr){
			$query = 'SELECT c.* FROM cita c JOIN cita_usuario cu ON c.id_cita = cu.id_cita WHERE tipo = "junta" AND estatus = "activo" AND fecha > NOW() AND cu.id_usuario = '.$id_usr.' ORDER BY fecha LIMIT 5';
			return $this->con->consultaRetorno($query);
		}
		
		public function getProximosAVencer($id_usr){
			$query = 'SELECT * FROM objetivo WHERE estatus = "activo" AND responsable = '.$id_usr.' ORDER BY fecha_vencimiento LIMIT 5';
			return $this->con->consultaRetorno($query);
		}

				

	}
 ?>