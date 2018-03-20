<?php namespace Models;

	class Conexion{

		private $datos = array(
			'host' => 'localhost',
			'user' => 'root',
			'pass' => '',
			'bd' => 'vitrobj_bd'
		);

		private $con;

		public function __construct(){
			$this->con = new \mysqli(
				$this->datos['host'],
				$this->datos['user'],
				$this->datos['pass'],
				$this->datos['bd'] );
			$this->con->query("SET NAMES utf8"); // para que muestre los acentos y ñ
		}

		public function consultaSimple($sql){
			$this->con->query($sql);
		}

		public function consultaRetorno($sql){
			return $this->con->query($sql);
		}

		public function getLastID(){
			return $this->con->insert_id;
		}
	} 


 ?>