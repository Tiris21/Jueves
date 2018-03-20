<?php namespace Models;

	class Accion{
		private $id;
		private $clase;
		private $fecha_creacion;
		private $comentario;
		private $id_objetivo;
		private $id_usuario;

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
			$query = "INSERT INTO accion SET clase = '$this->clase', fecha_creacion = '{$this->fecha_creacion}', comentario = '$this->comentario', id_objetivo = '{$this->id_objetivo}', id_usuario = '{$this->id_usuario}';";
			$this->con->consultaSimple($query);
		}

		public function getObjetivoPadre($op){
			$obj = $this->viewId($op);
			return $obj['objetivo_padre'];
		}




	}
 ?>