<?php namespace Models;

	class Accion{
		private $id;
		private $clase;
		private $fecha_creacion;
		private $comentario;
		private $id_objetivo;
		private $id_usuario;
		private $aux1;
		private $aux2;

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
			$query = 'SELECT * FROM accion WHERE id_objetivo = ' . $io . ' ORDER BY fecha_creacion';
			// $query = 'SELECT * FROM accion WHERE id_objetivo = '.$io.' OR (aux1 = '.$io.' AND clase = "apropiar") ORDER BY fecha_creacion';
			return $this->con->consultaRetorno($query);
		}

		public function usuariosResposablesAlAsignar($id_ob){
			$query = 'SELECT u.nombre FROM accion a JOIN usuario u ON a.id_usuario = u.id_usuario WHERE aux1 = "'.$id_ob.'" AND clase = "apropiar" ORDER BY fecha_creacion';
			return $this->con->consultaRetorno($query);
		}

		public function listarPorClase($c){
			$query = 'SELECT * FROM accion WHERE clase = "' . $c . '"';
			return $this->con->consultaRetorno($query);
		}

		public function add(){
			$query = "INSERT INTO accion SET clase = '$this->clase', fecha_creacion = NOW(), comentario = '{$this->comentario}', id_objetivo = '$this->id_objetivo', id_usuario = '$this->id_usuario', aux1 = '$this->aux1', aux2 = '$this->aux2';";
			$this->con->consultaSimple($query);
		}

		public function addCreacion($id){
			$this->clase = 'crear';
			$this->comentario = null;
			$this->id_objetivo = $id;
			$this->id_usuario = $_SESSION['id_usuario'];
			$this->aux1 = null;
			$this->aux2 = null;
			$this->add();
		}

		public function addAvanzar($id, $comentario, $antes, $ahora){
			$this->clase = 'avanzar';
			$this->comentario = $comentario;
			$this->id_objetivo = $id;
			$this->id_usuario = $_SESSION['id_usuario'];
			$this->aux1 = $antes;
			$this->aux2 = $ahora;
			$this->add();
		}

		public function addAsignar($id, $comentario){
			$this->clase = 'asignar';
			$this->comentario = $comentario;
			$this->id_objetivo = $id;
			$this->id_usuario = $_SESSION['id_usuario'];
			$this->aux1 = null;
			$this->aux2 = null;
			$this->add();
		}

		public function addApropiar($objetivo, $usuario, $obj_padre){
			$this->clase = 'apropiar';
			$this->comentario = null;
			$this->id_objetivo = $objetivo;
			$this->id_usuario = $usuario;
			$this->aux1 = $obj_padre;
			$this->aux2 = null;
			$this->add();
		}

		public function addComentar($objetivo, $comentario, $archivo){
			$this->clase = 'comentar';
			$this->comentario = $comentario;
			$this->id_objetivo = $objetivo;
			$this->id_usuario = $_SESSION['id_usuario'];
			$this->aux1 = $archivo;
			$this->aux2 = null;
			$this->add();
		}



	}
 ?>