<?php 
	namespace Controllers;

	use Models\Usuario as Usuario;

	class loginController{

		private $usuario;

		public function __construct(){
			$this->usuario = new Usuario();
		}

		public function index(){
			if ($_POST) {
				$usuarios = $this->usuario->listar();

				$elusuario = $_POST['usuario'];
				$password = $_POST['pass'];

				foreach ($usuarios as $user ) {
					if ($user['id_usuario']==$elusuario && $user['pass']==$password) {
						// session_start();
						$_SESSION['login'] = true;
						$_SESSION['id_usuario'] = $user['id_usuario'];
						$_SESSION['permiso'] = $user['nivel'];
						header("Location: " . URL . "tablero");
					}
				}

				return ['error' => 'error'];
			}
			
			return '';
		}

		public function logout(){
			session_start();
			session_unset(); 
			session_destroy(); 
			header("Location: " . URL . "login");
			// return ['vista' => 'false'];
		}

	}

?>