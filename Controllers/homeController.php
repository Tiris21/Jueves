<?php namespace Controllers;
	
	use Models\Dashboard as Dashboard;

	class homeController{

		private $dashboard;

		public function __construct(){
			$this->dashboard = new Dashboard();
		}

		public function index(){
			
			$citas = $this->dashboard->getCitasNuevas($_SESSION['id_usuario']);
			$avances = $this->dashboard->getAvancesNuevos($_SESSION['id_usuario']);
			$comentarios = $this->dashboard->getComentariosNuevos($_SESSION['id_usuario']);
			$asignaciones = $this->dashboard->getAsignacionesNuevas($_SESSION['id_usuario']);
var_dump($asignaciones); die;
			return ['vista' => 'index'];
		}
	} 


 ?>