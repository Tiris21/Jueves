<?php 

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', realpath(dirname(__FILE__)) . DS);
	define('URL', 'http://localhost/VitrObjetivos/');

	require_once "Config/Autoload.php";
	require_once "Funciones.php";
	
	// setlocale(LC_TIME,"es_MX");
	// header("Content-Type: text/html;charset=utf-8");

	Config\Autoload::run();

	session_start(); #INICIALIZACION DE LA VARIABLE DE SESSION

	Config\Enrutador::run(new Config\Request());

 ?>