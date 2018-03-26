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

		public function view(){
			$query = 'SELECT e.*, s.nombre FROM estudiantes e INNER JOIN secciones s ON e.id_seccion = s.id WHERE e.id = '.$this->id;
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row;
		}

		public function viewId($id){
			$query = 'SELECT e.*, s.nombre FROM estudiantes e INNER JOIN secciones s ON e.id_seccion = s.id WHERE id_usuario = '.$id;
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row;
		}
		

	}
 ?>