<?php namespace Models;

	class Accion{
		private $id;
		private $clase;
		private $fecha_creacion;
		private $comentario;
		private $id_objetivo;
		private $id_usuario;
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

		public function listarPorObjetivo($io){
			$query = 'SELECT * FROM accion WHERE id_objetivo = ' . $io;
			return $this->con->consultaRetorno($query);
		}

		public function listarPorClase($c){
			$query = 'SELECT * FROM accion WHERE clase = "' . $c . '"';
			return $this->con->consultaRetorno($query);
		}

		public function add(){
			$query = "INSERT INTO accion SET clase = '$this->clase', fecha_creacion = NOW(), comentario = '{$this->comentario}', id_objetivo = '$this->id_objetivo', id_usuario = '$this->id_usuario';";
			$this->con->consultaSimple($query);
		}

		public function addCreacion($id){
			$this->clase = 'crear';
			$this->comentario = null;
			$this->id_objetivo = $id;
			$this->id_usuario = $_SESSION['id_usuario'];
			$this->add();
		}

		public function addAvanzar($id, $comentario){
			$this->clase = 'avanzar';
			$this->comentario = $comentario;
			$this->id_objetivo = $id;
			$this->id_usuario = $_SESSION['id_usuario'];
			$this->add();
		}

		public function addAsignar($id, $comentario){
			$this->clase = 'asignar';
			$this->comentario = $comentario;
			$this->id_objetivo = $id;
			$this->id_usuario = $_SESSION['id_usuario'];
			$this->add();
		}

		public function addApropiar($objetivo, $usuario){
			$this->clase = 'apropiar';
			$this->comentario = null;
			$this->id_objetivo = $objetivo;
			$this->id_usuario = $usuario;
			$this->add();
		}

		public function addComentar($objetivo, $comentario){
			$this->clase = 'comentar';
			$this->comentario = $comentario;
			$this->id_objetivo = $objetivo;
			$this->id_usuario = $_SESSION['id_usuario'];
			$this->add();
		}



	}
 ?>