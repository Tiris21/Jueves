<?php 

	function formatearFecha($fecha){
		$meses_formato_fecha = array("barrio", "Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
		$fecha_formateada = date('d/' , strtotime($fecha));
		$fecha_formateada .= $meses_formato_fecha[date('n' , strtotime($fecha))];
		$fecha_formateada .= date('/Y' , strtotime($fecha));
		return $fecha_formateada;
	}

	function formatearFechaHora($fecha){
		$meses_formato_fecha = array("barrio", "Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
		$fecha_formateada = date('d/' , strtotime($fecha));
		$fecha_formateada .= $meses_formato_fecha [date('n' , strtotime($fecha)) ];
		$fecha_formateada .= date('/Y H:i' , strtotime($fecha));
		return $fecha_formateada; // M = Mes en tres letras
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