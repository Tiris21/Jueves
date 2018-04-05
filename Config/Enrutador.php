<?php namespace Config;

	class Enrutador{

		public static function run(Request $request){
			$controlador = $request->getControlador() . 'Controller';
			$ruta = ROOT . 'Controllers' . DS . $controlador . '.php';

			$metodo = $request->getMetodo();
			$argumento = $request->getArgumento();
			if (is_readable($ruta)) {
				require_once $ruta;
				$aux = "Controllers\\" . $controlador;
				$controlador = new $aux;

				if (!isset($argumento)) {
					$datos = call_user_func( array($controlador, $metodo));
				}else{
					$datos = call_user_func_array( array($controlador, $metodo), $argumento);
				}

				// ACOMODAR LAS VARIABLES
				if (is_array($datos)) {
					foreach ($datos as $variable => $valor) {
						$$variable = $valor;
					}
				}

				//SI NO EXISTE LA VARIABLE VISTA IGUALARLA A FALSE
				if(!isset($vista)) 
					$vista = false; 

			}else{
				# NO SE ENCUENTRA EL CONTROLADOR
				echo "error 404 file dont found: ".$ruta;
			}

//var_dump($vista); die;



			// Cargar vista
			// session_start(); #INICIALIZACION DE LA VARIABLE DE SESSION
			if ( $request->getControlador() == 'login' && $request->getMetodo() == 'index' ) {
			// SI ENTRA AL INDEX CONTROLADOR DEL LOGIN
				
				$ruta_login = ROOT . 'Views' . DS . 'template' . DS . 'login.php';
				require_once $ruta_login;

			} else if (!isset($_SESSION['id_usuario'])) {
			// SI NO ESTA LOGGEADO -> REDIRECCIONAR AL LOGIN
			
				header("Location: " . URL . "login");
				
			}else{
			// SI ESTA LOGGEADO Y CARGA UNA VISTA DISTINTA AL INDEX DEL LOGIN 
				if ($vista) {
					
					$ruta_vista = ROOT . 'Views' . DS . $request->getControlador() . DS . $vista . '.php';
					//$ruta_vista = ROOT . 'Views' . DS . $request->getControlador() . DS . $metodo . '.php';
					if (is_readable($ruta_vista)) {
						
						$ruta_head = ROOT . 'Views' . DS . 'template' . DS . 'head.php';
						require_once $ruta_head;
						
						$ruta_menu = ROOT . 'Views' . DS . 'template' . DS . 'menu.php';
						require_once $ruta_menu;

						require_once $ruta_vista;

						$ruta_footer = ROOT . 'Views' . DS . 'template' . DS . 'footer.php';
						require_once $ruta_footer;

					}else{
						// SI EL ARCHIVO DE LA VISTA NO SE ENCUENTRA
						echo 'no se encontro el archivo: ' . $ruta_vista;
					}

				}
			}


		}
	}


 ?>