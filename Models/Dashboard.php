<?php namespace Models;

	class Dashboard{

		private $con;

		public function __construct(){
			$this->con = new Conexion();
		}
	
		public function getNotificaciones($id_usr, $last_login){
			$query = 'select * from (SELECT a.*, o.titulo 
					FROM accion a 
					JOIN objetivo o ON o.id_objetivo = a.id_objetivo 
					WHERE a.fecha_creacion >= "'.$last_login.'" 
					AND a.clase <> "apropiar"
					AND (o.responsable = '.$id_usr.' 
					OR o.id_objetivo IN ( SELECT h.id_objetivo FROM objetivo h WHERE h.objetivo_padre IN ( SELECT p.id_objetivo FROM objetivo p WHERE p.responsable = '.$id_usr.' ) ) )
					UNION
					SELECT a.*, o.titulo 
					FROM accion a 
					JOIN objetivo o ON o.id_objetivo = a.id_objetivo 
					WHERE a.fecha_creacion >= "'.$last_login.'" 
					AND a.clase = "apropiar"
					AND a.id_usuario = '.$id_usr.')	w
					ORDER BY fecha_creacion DESC';
			$datos = $this->con->consultaRetorno($query);
			// var_dump($query); die;
			return $datos;
		}

		public function getCitasNuevas($id_usr, $last_login){
			$query = '	SELECT COUNT(*) AS total
						FROM cita c
						JOIN cita_usuario cu ON c.id_cita = cu.id_cita
						WHERE c.tipo = "junta"
						AND c.estatus = "activo"
						AND c.fecha > "'.$last_login.'"
						AND cu.id_usuario = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['total'];
		}

		public function getAvancesNuevos($id_usr, $last_login){
			$query = '	SELECT COUNT(*) AS total
						FROM accion a
						JOIN objetivo o ON o.id_objetivo = a.id_objetivo
						WHERE a.clase = "avanzar"
						AND o.estatus = "activo"
						AND a.fecha_creacion > "'.$last_login.'"
						AND o.responsable = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['total'];
		}

		public function getComentariosNuevos($id_usr, $last_login){
			$query = '	SELECT COUNT(*) AS total
						FROM accion a
						JOIN objetivo o ON o.id_objetivo = a.id_objetivo
						WHERE a.clase = "comentar"
						AND o.estatus = "activo"
						AND a.fecha_creacion > "'.$last_login.'"
						AND o.responsable = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['total'];
		}

		public function getAsignacionesNuevas($id_usr, $last_login){
			$query = '	SELECT COUNT(*) AS total
						FROM accion a
						WHERE a.clase = "apropiar"
						AND a.fecha_creacion > "'.$last_login.'"
						AND a.id_usuario = "'.$id_usr.'"';
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['total'];
		}

		public function getDatosGrafica($id_usr){
			$query = 'SELECT * FROM objetivo WHERE responsable = ' . $id_usr . ' AND estatus = "activo"';
			$mis_obj = $this->con->consultaRetorno($query);

			$verdes = 0;
			$rojos = 0;
			$amarillos = 0;
			foreach ($mis_obj as $obj) {
				switch ( getColorPorPorcentaje($obj['avance'], $obj['dias'], $obj['fecha_vencimiento'])  ) {
					case 'success':
						$verdes++;
					break;
					
					case 'danger':
						$rojos++;
					break;

					case 'warning':
						$amarillos++;
					break;
				}
			}

			return [$rojos, $amarillos, $verdes];
			// return [ $this->getDatosGraficaRojo($id_usr), $this->getDatosGraficaAmarillo($id_usr), $this->getDatosGraficaVerde($id_usr) ];
		}

		// public function getDatosGraficaRojo($id_usr){
		// 	$query = 'SELECT COUNT(*) AS rojo FROM objetivo WHERE estatus = "activo" AND avance < 30 AND responsable = "'.$id_usr.'"';
		// 	$datos = $this->con->consultaRetorno($query);
		// 	$row = mysqli_fetch_assoc($datos);
		// 	return $row['rojo'];
		// }

		// public function getDatosGraficaAmarillo($id_usr){
		// 	$query = 'SELECT COUNT(*) AS amarillo FROM objetivo WHERE estatus = "activo" AND avance > 31 AND avance < 70 AND responsable = "'.$id_usr.'"';
		// 	$datos = $this->con->consultaRetorno($query);
		// 	$row = mysqli_fetch_assoc($datos);
		// 	return $row['amarillo'];
		// }

		// public function getDatosGraficaVerde($id_usr){
		// 	$query = 'SELECT COUNT(*) AS verde FROM objetivo WHERE estatus = "activo" AND avance >= 70 AND responsable = "'.$id_usr.'"';
		// 	$datos = $this->con->consultaRetorno($query);
		// 	$row = mysqli_fetch_assoc($datos);
		// 	return $row['verde'];
		// }

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