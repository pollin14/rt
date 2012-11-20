<?php

//Datos de conexion
define("HOST","localhost");
define("USER", "rt");
define("PASSWORD","r2d2");
define("DB","tutorias");

//Encabezados del email.
define("HEADERS_MAIL",
		"MIME-Version: 1.0\r\nContent-type: text/html; charset=utf8\r\nFrom: rt@sep.gob.mx\r\nReply-To: no-reply\r\n");

//Identificadores de estapas
define('DEMOSTRACION',5);

//Ruta base. La idea es usarla para los productos y recursos.

define('REMOTE_SERVER', 'http://smg/rt/');
//switch ( $_SERVER['SERVER_ADDR']){
//	case('168.255.153.109'):
//		define('SERVER_PATH','http://168.255.101.69/rt/');
//		break;
//	case ('10.85.16.70'):
//		define('SERVER_PATH', 'smg/rt/');
//		break;
//	case ('168.255.101.69'):
//		define('SERVER_PATH','http://168.255.101.69/rt/');
//		break;
//	default:
//		define('SERVER_PATH','smg/rt/');
//}

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