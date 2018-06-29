<?php namespace Models;

	class Objetivo{
		private $id;
		private $titulo;
		private $descripcion;
		private $tipo_avance;
		private $dias;
		private $fecha_asignacion;
		private $fecha_vencimiento;
		private $avance;
		private $prioridad;
		private $estatus;
		private $asignador;
		private $responsable;
		private $objetivo_padre;
		private $id_departamento;
		
		private $con;
		private $accion;

		public function __construct(){
			$this->con = new Conexion();
			$this->accion = new Accion();
		}

		public function set($atributo, $contenido){
			$this->$atributo = $contenido;
		}

		public function get($atributo){
			return $this->$atributo;
		}

		public function listarMisObjetivos($id_usuario){
			$query = 'SELECT *, d.nombre as departamento FROM objetivo o LEFT JOIN departamento d ON d.id_departamento = o.id_departamento WHERE o.responsable = ' . $id_usuario . ' AND o.estatus = "activo"';
			return $this->con->consultaRetorno($query);
		}

		public function listarObjetivosHijos($id_ob){
			$query = 'SELECT * FROM objetivo WHERE objetivo_padre = ' . $id_ob . ' AND estatus = "activo"';
			return $this->con->consultaRetorno($query);
		}

		public function listarSubobjetivos($id_op){
			$query = 'SELECT o.*, u.nombre FROM objetivo o JOIN usuario u ON o.responsable = u.id_usuario WHERE objetivo_padre = ' . $id_op . ' AND o.estatus = "activo" AND u.estatus = "activo"';
			return $this->con->consultaRetorno($query);
		}

		public function listarObjetivosDeEquipo($id_usuario){
			$query = 'SELECT o.*, u.nombre FROM objetivo o JOIN usuario u ON o.responsable = u.id_usuario AND u.usuario_jefe = "'.$id_usuario.'" WHERE o.estatus = "activo" AND o.asignador = "'.$id_usuario.'" AND u.estatus = "activo" ';
			return $this->con->consultaRetorno($query);
		}

		public function viewId($id){
			$query = 'SELECT o.*, u.nombre FROM objetivo o JOIN usuario u ON o.responsable = u.id_usuario WHERE id_objetivo = '.$id;
			$datos = $this->con->consultaRetorno($query);
			// if ($datos){
			// 	$row = mysqli_fetch_assoc($datos);
			// }else{
			// 	$row = null;
			// }
			$row = mysqli_fetch_assoc($datos);
			return $row;
		}

		public function add(){
			$query = "INSERT INTO objetivo SET titulo = '$this->titulo', descripcion = '{$this->descripcion}', tipo_avance = 'individual', dias = '{$this->dias}', fecha_asignacion = '{$this->fecha_asignacion}', fecha_vencimiento = '{$this->fecha_vencimiento}', avance = 0, prioridad = '{$this->prioridad}', estatus = 'activo', asignador = '{$this->asignador}', responsable = '{$this->responsable}', id_departamento = '{$this->id_departamento}', objetivo_padre = '{$this->objetivo_padre}';";
			return $this->con->consultaSimpleID($query);
		}

		public function crear(){
			$id_obj = $this->add();
			//ACCION
			$this->accion->addCreacion($id_obj);

			return $id_obj;
		}

		public function avanzar($id, $porcentaje, $comentario){
			$obj = $this->viewId($id);

			$query = 'UPDATE objetivo SET avance = '.$porcentaje.'  WHERE id_objetivo = '.$id;
			$this->con->consultaSimple($query);
			//ACCION
			$this->accion->addAvanzar($id, $comentario, $obj['avance'], $porcentaje);
			// METODO RECURSIVO D: NAA JUST KIDDIN :3
			$this->setAvancePadres($id);
			
		}

		public function asignar($id, $responsables, $comentario){
			foreach ($responsables as $responsable) {
				$this->set('responsable', $responsable);
				$id_nuevo = $this->add();
				
				// ACCION
				$this->accion->addApropiar($id_nuevo, $responsable, $id);

				$id_nuevos[] = $id_nuevo;
			}

			$query = 'UPDATE objetivo SET tipo_avance = "asignado", avance = '.$this->getPorcentajeAvance($id).'  WHERE id_objetivo = '.$id;
			$this->con->consultaSimple($query);
			//ACCION
			$this->accion->addAsignar($id, $comentario);
			// AL ASIGNAR SE ACTUALIZAN LOS PORCENTAJES DE AVANCE DE LOS PADRES
			$this->setAvancePadres($id);

			return $id_nuevos;
		}

		public function setAvancePadres($id_hijo){
			// MIENTAS exist(OBJETIVO PADRE) { UPDATE PORCENTAJE DE OBJPADRE }
			$id_objetivopadre = $this->getObjetivoPadre($id_hijo);

			while( $id_objetivopadre > 0){
				$porcentaje = $this->getPorcentajeAvance($id_objetivopadre);
				$query = 'UPDATE objetivo SET avance = '.$porcentaje.'  WHERE id_objetivo = '.$id_objetivopadre;
				$this->con->consultaSimple($query);
				
					//ACCION esto se agrego sobre la marcha
					$obj = $this->viewId($id_objetivopadre); 
					$this->accion->addAvanzar($id_objetivopadre, "Avance automatico por un objetivo de un nivel abajo (".$id_hijo.")", $obj['avance'], $porcentaje);
					// hasta aqui juer juer

					// ESTO DEL ENVIO DE CORREOS TAMBIEN SOBRE LA MARCHA SE AGREGO
					if ($porcentaje >= 100) {
						$correo = new Correo();
						$correo->sendComplete($id_objetivopadre);
					}
					// JUAR JUAR
				
				$id_objetivopadre = $this->getObjetivoPadre($id_objetivopadre);
			}
		}

		public function getPorcentajeAvance($op){
			$query = "SELECT ROUND( AVG(avance) , 2) AS avg FROM objetivo WHERE objetivo_padre = ".$op." AND estatus = 'activo'";
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row['avg'];
		}

		public function getObjetivoPadre($op){
			$obj = $this->viewId($op);
			return $obj['objetivo_padre'];
		}

		public function editar($id_ob){
			$query = "UPDATE objetivo SET titulo = '$this->titulo', descripcion = '{$this->descripcion}', dias = '{$this->dias}', fecha_asignacion = '{$this->fecha_asignacion}', fecha_vencimiento = '{$this->fecha_vencimiento}', prioridad = '{$this->prioridad}' WHERE id_objetivo = ".$id_ob;
			$this->con->consultaSimple($query);
		}

		private function darBaja($id_ob){
			$query = 'UPDATE objetivo SET estatus = "baja"  WHERE id_objetivo = '.$id_ob;
			$this->con->consultaSimple($query);
		}

		public function eliminar($id_obj){
			$this->darBaja($id_obj);
			
			$objetivos_hijos = $this->listarObjetivosHijos($id_obj);
			
			foreach ($objetivos_hijos as $oh) {
				$hoh = $this->listarObjetivosHijos($oh['id_objetivo']);

				if ($hoh->num_rows > 0) {
					return $this->eliminar($oh['id_objetivo']);
				}else{
					$this->darBaja($oh['id_objetivo']);
				}

			}

		}

		public function permisoJerarquico($usr_gfe, $usuario_objetivo){
			# AH PERRO UN RECURSIVO :v
			$el_equipo_de = $this->listarMiEquipo($usr_gfe);
			
			foreach ($el_equipo_de as $sub) {
				if ($sub['id_usuario'] == $usuario_objetivo) {
					return 'eaaaa';
				}else {
					// si la funcion regresa null, no retorna nada para que pase al siguiente paso del foreach
					$aux = $this->permisoJerarquico($sub['id_usuario'], $usuario_objetivo);
					if ( ! is_null($aux) ) {
						return $aux;
					}
				}
				
			}

		}

		public function obtenerResponsables($id_obj){
			$query = 'SELECT DISTINCT u.nombre FROM objetivo o JOIN usuario u ON u.id_usuario = o.responsable WHERE objetivo_padre = '.$id_obj;
			$responsables = $this->con->consultaRetorno($query);
			$str_respon = '';
			$cont = 1;
			foreach ($responsables as $r) {
				$str_respon .= $r['nombre'];
				if ($cont != $responsables->num_rows) {
					$str_respon .= ', ';
				}
				$cont++;
			}
			return $str_respon;
		}


		public function vieneDeUnAsginadoMio($id_objetivo, $usuario){
			$aux_obj = $this->viewId($id_objetivo);
			while ($aux_obj && $usuario != $aux_obj['responsable'] ) {
				$aux_obj = $this->viewId($aux_obj['objetivo_padre']);
			}
			if ($usuario == $aux_obj['responsable'])
				return true;
			else
				return false;
		}


	}
 ?>