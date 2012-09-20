<?php
header('Content-Type: text/xml; charset=UTF-8');

include "../../../../configuracion.php";
include "../../../../lib/php/utils.php";
include "funciones.php";


$idTutoria = $_POST['idTutoria'];
$tipoDeUsuario = $_POST['tipoDeUsuario'];

$db = dameConexion();

$idEtapa = fetchUltimaEtapa($idTutoria, $db);

$xml = '<?xml version="1.0" encoding="utf-8"?><tutoria>';
$xml .= fetchMensajesNuevos($idTutoria,0,$idEtapa,$tipoDeUsuario,"historial",$db,50);
$xml .= fetchNumProductos($idTutoria,$db);
$xml .= '</tutoria>';

$db->close();
print($xml);
?>
