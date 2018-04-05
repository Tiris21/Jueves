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

		public function listarMiEquipo($uj){
			$query = 'SELECT * FROM usuario WHERE estatus <> "baja" AND usuario_jefe = ' . $uj;
			return $this->con->consultaRetorno($query);
		}

				

	}
 ?>