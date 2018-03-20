<?php namespace Controllers;
	
	//use Models\Estudiante as Estudiante;

	class objetivosController{

		// private $estudiante;

		public function __construct(){
			//$this->estudiante = new Estudiante();
		}

		public function index(){
			$datos = ['vista' => 'index'];//$this->estudiante->listar();
			return $datos;
		}

		public function asignados(){
			$datos = '';
			return $datos;
		}
	} 


 ?>