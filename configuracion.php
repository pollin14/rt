<?php

//Datos de conexion
define("HOST","localhost");
define("USER", "rt");
define("PASSWORD","r2d2");
define("DB","tutorias");
define("HEADERS_MAIL",
		"MIME-Version: 1.0\r\nContent-type:text/html\r\nContent-type: text/html; charset=utf8\r\nFrom: Red de Tutorias (RT)\r\nReply-To: no-reply\r\n");

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
		echo "No has iniciado session.";
        header('Location: http://' . $_SERVER['SERVER_NAME']. "/rt");
        exit();
    }
}
?>