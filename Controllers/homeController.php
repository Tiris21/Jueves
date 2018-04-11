<?php namespace Controllers;
	
	use Models\Dashboard as Dashboard;
	use Models\Usuario as Usuario;

	class homeController{

		private $dashboard;
		private $user;

		public function __construct(){
			$this->dashboard = new Dashboard();
			$this->user = new Usuario();
		}

		public function index(){
			
			$citas = $this->dashboard->getCitasNuevas($_SESSION['id_usuario']);
			$avances = $this->dashboard->getAvancesNuevos($_SESSION['id_usuario']);
			$comentarios = $this->dashboard->getComentariosNuevos($_SESSION['id_usuario']);
			$asignaciones = $this->dashboard->getAsignacionesNuevas($_SESSION['id_usuario']);

			$grafica = $this->dashboard->getDatosGrafica($_SESSION['id_usuario']);
			
			$next_dates = $this->dashboard->getProximasCitas($_SESSION['id_usuario']);

			$next_expire = $this->dashboard->getProximosAVencer($_SESSION['id_usuario']);

			$cambiaContra = $this->user->getContra();
			if ($cambiaContra == '123') {
				$cambiaContra = 'undostres';
			}else{
				$cambiaContra = '';
			}
	// var_dump($cambiaContra); die;

			return ['vista' => 'index', 'citas' => $citas, 'avances' => $avances, 'comentarios' => $comentarios, 'asignaciones' => $asignaciones, 'grafica' => $grafica, 'next_dates' => $next_dates, 'next_expire' => $next_expire, 'cambiaContra' => $cambiaContra];
		}

		public function cambiar_password(){
			if ($_POST) {
				$this->user->cambiarContra($_POST['pass1']);
			}

			header("Location: " . URL . "Home");
		}
	} 


 ?>