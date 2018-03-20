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

		public function __construct(){
			$this->con = new Conexion();
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

		public function viewId($id){
			$query = 'SELECT o.*, u.nombre FROM objetivo o JOIN usuario u ON o.responsable = u.id_usuario WHERE id_objetivo = '.$id;
			$datos = $this->con->consultaRetorno($query);
			$row = mysqli_fetch_assoc($datos);
			return $row;
		}

		public function add(){
			$query = "INSERT INTO objetivo SET titulo = '$this->titulo', descripcion = '{$this->descripcion}', tipo_avance = 'individual', dias = '{$this->dias}', fecha_asignacion = '{$this->fecha_asignacion}', fecha_vencimiento = '{$this->fecha_vencimiento}', avance = 0, estatus = 'activo', asignador = '{$this->asignador}', responsable = '{$this->responsable}', objetivo_padre = '{$this->objetivo_padre}';";
			$this->con->consultaSimple($query);
		}		

		public function avanzar($id, $porcentaje){
			$query = 'UPDATE objetivo SET avance = '.$porcentaje.'  WHERE id_objetivo = '.$id;
			$this->con->consultaSimple($query);
			// METODO RECURSIVO D: NAA JUST KIDDIN :3
			$this->setAvancePadres($id);
			
		}

		public function asignar($id, $responsables){
			foreach ($responsables as $responsable) {
				$this->set('responsable', $responsable);
				$this->add();
			}

			$query = 'UPDATE objetivo SET tipo_avance = "asignado", avance = '.$this->getPorcentajeAvance($id).'  WHERE id_objetivo = '.$id;
			$this->con->consultaSimple($query);

			// AL ASIGNAR SE ACTUALIZAN LOS PORCENTAJES DE AVANCE DE LOS PADRES
			$this->setAvancePadres($id);
		}

		public function setAvancePadres($id_hijo){
			// MIENTAS exist(OBJETIVO PADRE) { UPDATE PORCENTAJE DE OBJPADRE }
			$id_objetivopadre = $this->getObjetivoPadre($id_hijo);

			while( $id_objetivopadre > 0){
				$query = 'UPDATE objetivo SET avance = '.$this->getPorcentajeAvance($id_objetivopadre).'  WHERE id_objetivo = '.$id_objetivopadre;
				$this->con->consultaSimple($query);
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