<?php

//Datos de conexion
define("HOST","localhost");
define("USER", "rt");
define("PASSWORD","r2d2");
define("DB","tutorias");

//Identificadores de estapas
define('DEMOSTRACION',5);

date_default_timezone_set("America/Mexico_City");

function dameConexion(){

	$db = new mysqli(HOST,USER,PASSWORD,DB);
	
	if(!$db) die ("Error al conectarse a la base de datos.");
	$db ->set_charset('utf8');
        
	return $db;
}

function administraSesion(){
    if(!isset($_SESSION['idUsuario'])){
		echo "<p>No has iniciado session.</p>";
		echo "<p>Si no eres redireccionado a la pantalla de inicio preciona el siguiente link</p>";
		echo "<a href=\"http://" . $_SERVER['SERVER_NAME'] . "\">Pagina de inicio </p>"; 
        header('Location: http://' . $_SERVER['SERVER_NAME'] ."/rt");
        exit();
    }
}
?>