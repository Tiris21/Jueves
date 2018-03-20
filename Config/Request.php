<?php namespace Config;

	class Request{

		private $controlador;
		private $metodo;
		private $argumento;

		public function __construct(){
			if( isset($_GET['url']) ){
				$ruta = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
				$ruta = explode('/', $ruta);
				$ruta = array_filter($ruta);

				$this->controlador = strtolower( array_shift($ruta) );
				$this->metodo = ($ruta) ? strtolower( array_shift($ruta) ) : 'index';
				$this->argumento = $ruta;// ($ruta) ?  strtolower( array_shift($ruta) ) : null ;
			}
			else{
				$this->controlador = 'tablero';
				$this->metodo = 'index';
				# PARA QUE SI ENTRE AL CONTROLADOR
				// header("Location: " . URL . "Tablero");
			}
		}

		public function getControlador(){
			return $this->controlador;
		}

		public function getMetodo(){
			return $this->metodo;
		}

		public function getArgumento(){
			return $this->argumento;
		}


	}




 ?>