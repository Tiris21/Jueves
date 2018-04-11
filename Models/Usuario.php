<?php namespace Models;

	class Usuario{
		private $id;
		private $nombre;
		private $correo;
		private $pass;
		private $estatus;
		private $puesto;
		private $nivel;
		private $usuario_jefe;
		private $last_login;

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

		public function listar(){
			$query = 'SELECT * FROM usuario WHERE estatus <> "baja"';
			return $this->con->consultaRetorno($query);
		}

		public function listarMiEquipo($uj){
			$query = 'SELECT * FROM usuario WHERE estatus <> "baja" AND usuario_jefe = ' . $uj;
			return $this->con->consultaRetorno($query);
		}

		public function add(){
			$query = "INSERT INTO usuario(id_usuario, nombre, correo, pass, estatus, puesto, nivel, usuario_jefe) 
				VALUES (NULL, '$this->nombre', '{$this->correo}', '{$this->pass}', '{$this->puesto}', '{$this->nivel}', '{$this->usuario_jefe}')";
			$this->con->consultaSimple($query);
		}

		public function detele(){
			$query = "DELETE FROM usuario WHERE id = ".$this->id;
			$this->con->consultaSimple($query);
		}

		public function edit(){
			$query = "UPDATE usuario SET nombre = '{$this->nombre}', nombre = '{$this->nombre}', edad = '{$this->edad}', promedio = '{$this->promedio}',
					id_seccion = '{$this->id_seccion}' WHERE id = ".$this->id;
			$this->con->consultaSimple($query);
		}

		public function viewId($id){
			$query = 'SELECT * FROM usuario WHERE id_usuario = '.$id;
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row;
		}

		public function permisoJerarquico($usr_gfe, $usuario_objetivo){
			# AH PERRO UN RECURSIVO
			$el_equipo_de = $this->listarMiEquipo($usr_gfe);
			
			foreach ($el_equipo_de as $sub) {
				if ($sub['id_usuario'] == $usuario_objetivo) {
					return 'eaaaa';
				}else {
					// si la funcion regresa null, no retorna nada para que pase al siguiente paso del foreach
					$aux = $this->permisoJerarquico($sub['id_usuario'], $usuario_objetivo);
					if ( ! is_null($aux) ) {
						return $aux;
					}
				}
				
			}

		}

		// actualizza el campo de last_login
		public function setLastLogin($id){
			$query = "UPDATE usuario SET last_login = NOW() WHERE id_usuario = ".$id;
			$this->con->consultaSimple($query);
		}

		// actualizza la contraseña
		public function cambiarContra($pass){
			$query = "UPDATE usuario SET pass = '". $pass ."'' WHERE id_usuario = ".$id;
			$this->con->consultaSimple($query);
		}

		public function getContra(){
			$query = 'SELECT * FROM usuario WHERE id_usuario = '.$_SESSION['id_usuario'];
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['pass'];
		}		

	}
 ?>