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
		private $estatus;
		private $asignador;
		private $responsable;
		private $objetivo_padre;
		
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
			$query = 'SELECT * FROM objetivo WHERE responsable = ' . $id_usuario . ' AND estatus = "activo"';
			return $this->con->consultaRetorno($query);
		}

		public function listarSubobjetivos($id_op){
			$query = 'SELECT o.*, u.nombre FROM objetivo o JOIN usuario u ON o.responsable = u.id_usuario WHERE objetivo_padre = ' . $id_op . ' AND o.estatus = "activo" AND u.estatus = "activo"';
			return $this->con->consultaRetorno($query);
		}

		public function listarObjetivosDeEquipo($id_usuario){
			$query = 'SELECT o.*, u.nombre FROM objetivo o JOIN usuario u ON o.responsable = u.id_usuario AND u.usuario_jefe = "'.$id_usuario.'" WHERE o.estatus = "activo" AND u.estatus = "activo" ';
			return $this->con->consultaRetorno($query);
		}

		public function viewId($id){
			$query = 'SELECT o.*, u.nombre FROM objetivo o JOIN usuario u ON o.responsable = u.id_usuario WHERE id_objetivo = '.$id;
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row;
		}

		public function add(){
			$query = "INSERT INTO objetivo SET titulo = '$this->titulo', descripcion = '{$this->descripcion}', tipo_avance = 'individual', dias = '{$this->dias}', fecha_asignacion = '{$this->fecha_asignacion}', fecha_vencimiento = '{$this->fecha_vencimiento}', avance = 0, estatus = 'activo', asignador = '{$this->asignador}', responsable = '{$this->responsable}', objetivo_padre = '{$this->objetivo_padre}';";
			return $this->con->consultaSimpleID($query);
		}

		public function crear(){
			$id_obj = $this->add();
			//ACCION
			$this->accion->addCreacion($id_obj);
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
				//ACCION
				$this->accion->addApropiar($id_nuevo, $responsable, $id);
			}

			$query = 'UPDATE objetivo SET tipo_avance = "asignado", avance = '.$this->getPorcentajeAvance($id).'  WHERE id_objetivo = '.$id;
			$this->con->consultaSimple($query);
			//ACCION
			$this->accion->addAsignar($id, $comentario);
			// AL ASIGNAR SE ACTUALIZAN LOS PORCENTAJES DE AVANCE DE LOS PADRES
			$this->setAvancePadres($id);
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
					$this->accion->addAvanzar($id_objetivopadre, "Avance ocacionado por un objetivo de un nivel abajo (".$id_objetivopadre.")", $obj['avance'], $porcentaje);
					// hasta aqui juer juer
				
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





	}
 ?>