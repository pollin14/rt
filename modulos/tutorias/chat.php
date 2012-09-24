<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

include "../../configuracion.php";
include "../../lib/php/utils.php";
include "lib/php/funciones.php";

administraSesion();
$db = dameConexion();

//Datos enviados por el usuario.
$idTutoria = $_POST['idTutoria'];
$idUsuario = $_SESSION['idUsuario'];
$mensaje = $db->real_escape_string($_POST['mensaje']);
$idEtapa = $_POST['idEtapa'];
$tipoDeUsuario = $_POST['tipoDeUsuario'];
$idUltimoMensaje = $_POST['idUltimoMensaje'];


//$borrar = "1"; //minutos
$error = "";
$autorizacion = ($tipoDeUsuario === "sinodal")? 0: 1;

saveMensaje($idTutoria,$idUsuario,$idEtapa,$autorizacion,$mensaje,$db);

////Borramos mensajes viejos.
//$query = sprintf('
//    delete from Mensajes 
//        where idtutoria=%d and fecha < DATE_SUB("%s", INTERVAL %d MINUTE);'
//        ,$idTutoria,$fecha, $borrar);
//
//if(! $db -> query($query)){
//    echo $query;
//}

$xml = '<?xml version="1.0" encoding="utf-8"?><tutoria>';
$xml .= fetchMensajesNuevos($idTutoria,$idUltimoMensaje,$idEtapa,$tipoDeUsuario,"mensajes",$db);
$xml .= fetchNumProductos($idTutoria, $db);
$xml .= '</tutoria>';

$db->close();
print($xml);
?>
