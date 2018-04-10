<?php namespace Controllers;
	
	use Models\Objetivo as Objetivo;
	use Models\Usuario as Usuario;
	use Models\Cita as Cita;

	class agendaController{

		private $objetivo;
		private $usuario;
		private $cita;

		public function __construct(){
			$this->objetivo = new Objetivo();
			$this->usuario = new Usuario();
			$this->cita = new Cita();
		}

		public function index(){
			$mis_citas = '';
			$mi_equipo = '';
			$mis_objetivos = '';
			if (isset($_SESSION['id_usuario'])) {
				$mis_citas = $this->cita->listarMisCitas($_SESSION['id_usuario']);
				$mi_equipo = $this->usuario->listarMiEquipo($_SESSION['id_usuario']);
				$mis_objetivos = $this->objetivo->listarMisObjetivos($_SESSION['id_usuario']);
			}

			return ['vista' => 'index', 'mis_citas' => $mis_citas, 'mi_equipo' => $mi_equipo, 'mis_objetivos' => $mis_objetivos];
		}


		public function nueva(){
			if ($_POST) {
				if (isset($_POST['check'])) {
				// si lleva periodicidad la cita 
					switch ($_POST['frecuencia']) {
						case 'mensual':
							if ($_POST['radio-mensual'] == 'numero') {
							// repetir por numero de dia
								
								$fecha_inicio = strtotime( $_POST['fecha_inicio'] );
								$fecha_aux = date('Y-m',$fecha_inicio)  .'-'. $_POST['dia_mensual'] . ' ' . $_POST['hora'] ;
								$aux = strtotime( $fecha_aux );
								if ($aux < strtotime('now') ) {
									$aux = strtotime( $fecha_aux . ' +1 month' );	
									$fecha_aux = date('Y-m-d H:i',$aux) ;
								}

								if ($_POST['radio-fin'] == 'for') {
								// finalizar por cantiddad de repeticiones
									for( $r=1; $r <= $_POST['repeticiones']; $r++){
										$this->agregarCita( $fecha_aux, $_POST['asunto'], $_POST['responsables'], $_POST['objetivo'] );
										$aux = strtotime( $fecha_aux . ' +1 month' );
										$fecha_aux = date('Y-m-d H:i',$aux);
									}

								}else{
								// finalizar por fecha limite
									$fecha_fin = strtotime( $_POST['fecha_fin'] );
									while ( $aux <= $fecha_fin) {
										$this->agregarCita( $fecha_aux, $_POST['asunto'], $_POST['responsables'], $_POST['objetivo'] );
										$aux = strtotime( $fecha_aux . ' +1 month' );
										$fecha_aux = date('Y-m-d H:i',$aux);
									}

								}

							}else{
							//repetir por primer, segundo, tercer jueves de cada mes 
								$fecha_inicio = new \DateTime( $_POST['fecha_inicio'] );
								$str = $_POST['posicion'] . ' ' . $_POST['dia_semana'] . ' of this month' ;
								$fecha_date = $fecha_inicio;
								$fecha_aux = $fecha_inicio->modify($str)->format('Y-m-d') . ' ' . $_POST['hora'] ;

								if ( strtotime($fecha_aux) < strtotime('now') ) {
									$fecha_date->modify('+1 month');	
									$fecha_aux = $fecha_date->modify($str)->format('Y-m-d') . ' ' . $_POST['hora'] ;
								}

								if ($_POST['radio-fin'] == 'for') {
								// finalizar por cantiddad de repeticiones
									for( $r=1; $r <= $_POST['repeticiones']; $r++){
										$this->agregarCita( $fecha_aux, $_POST['asunto'], $_POST['responsables'], $_POST['objetivo'] );
										$fecha_date->modify('+1 month');
										$fecha_aux = $fecha_date->modify($str)->format('Y-m-d') . ' ' . $_POST['hora'] ;
									}

								}else{
								// finalizar por fecha limite
									$fecha_fin = strtotime( $_POST['fecha_fin'] );
									$aux = strtotime($fecha_aux);
									while ( $aux <= $fecha_fin) {
										$this->agregarCita( $fecha_aux, $_POST['asunto'], $_POST['responsables'], $_POST['objetivo'] );
										$fecha_date->modify('+1 month');
										$fecha_aux = $fecha_date->modify($str)->format('Y-m-d') . ' ' . $_POST['hora'];
										$aux = strtotime($fecha_aux);
									}

								}
							}
							
							break;
							
						case 'semanal':
							$fecha_inicio = strtotime( $_POST['fecha_inicio'] );
							$aux = $fecha_inicio;

							if ($_POST['radio-fin'] == 'for') {
								$cont = 0;
								while ( $cont < $_POST['repeticiones']) {
									$fecha_aux = date('Y-m-d', $aux);
									foreach ($_POST['dias_check'] as $dia) {
										if ($dia == date('N',$aux)) {
											$this->agregarCita( $fecha_aux . ' ' . $_POST['hora'], $_POST['asunto'], $_POST['responsables'], $_POST['objetivo'] );
											$cont++;
										}
									}
									$aux = strtotime( $fecha_aux . ' +1 day' );
								}

							} else{
							// por fecha limite
								$fecha_fin = strtotime( $_POST['fecha_fin'] );
								while ( $aux <= $fecha_fin ) {
									$fecha_aux = date('Y-m-d', $aux);
									foreach ($_POST['dias_check'] as $dia) {
										if ($dia == date('N',$aux)) {
											$this->agregarCita( $fecha_aux . ' ' . $_POST['hora'], $_POST['asunto'], $_POST['responsables'], $_POST['objetivo'] );
										}
									}
									$aux = strtotime( $fecha_aux . ' +1 day' );
								}
							}
							break;
					}

				}else{
					// solo es una cita a guardar
					agregarCita($_POST['fecha_inicio'] . ' ' . $_POST['hora'], $_POST['asunto'], $_POST['responsables'], $_POST['objetivo']);
				}
			}

			header("Location: " . URL . "Agenda");
		}


	private function agregarCita($f, $t, $u, $o){
		$this->cita->set('fecha', $f);
		$this->cita->set('titulo', $t);
		$this->cita->set('usuarios', $u);
		$this->cita->set('id_objetivo', $o);
		$this->cita->add();
	} 



	} 


 ?>