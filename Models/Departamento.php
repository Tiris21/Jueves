<?php namespace Models;

	class Departamento{
		private $id;
		private $nombre;
		private $departamento_padre;
		private $estatus;

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

		public function listarMisDepartamentos($id_u){
			$query = 'SELECT d.* FROM departamento d JOIN departamento_usuario du ON d.id_departamento = du.id_departamento WHERE d.estatus <> "baja" AND du.id_usuario = ' . $id_u;
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
			$query = 'SELECT * FROM departamento WHERE id_departamento = '.$id;
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row;
		}
	

	}
 ?>