<?php 

	function formatearFecha($fecha){
		return date("d/m/Y", strtotime($fecha));
	}

	function difDiasAHoy($fecha){
		$fecha1 = strtotime($fecha);
		$hoy = strtotime(date("Y-m-d"));
		return round(($fecha1 - $hoy) / 86400);
	}

	function getColorPorPorcentaje($porcentaje){
		if ($porcentaje < 30) {
			$color = 'danger';
		}else if ($porcentaje < 70) {
			$color = 'warning';
		}else {
			$color = 'success';
		}

		return $color;
	}

 ?>