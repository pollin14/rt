<?php
session_start();
include "../../configuracion.php";
include "../../lib/php/utils.php";
include "../../lib/php/queries.php";
include "../../modulos/tutorias/lib/php/funciones.php";

header('Content-Type: text/html; charset=UTF-8');
header('refresh:3; url="../../modulos/mensajesPrivados/bandejaDeEntrada.php"'); 

administraSesion();

$db = dameConexion();

$para = $_GET['idTutorado'];
$de = $_SESSION['idUsuario'];
$asunto = "Aceptado";

$idTema = $_GET['idTema'];

$fecha = getActualDate();
	
$nombreDelTutorado = dameNombreDelUsuario($para,$db);
$nombreDelTema = dameNombreDelTema($idTema,$db);
$nombreDelTutor = dameNombreDelTutorDelTema($idTema,$db);

$mensaje = "<p>Hola <b>" . $nombreDelTutorado ."</b>!</p> <p>Fuiste aceptado en la tutoría";
$mensaje .= " con el tema <b>" . $nombreDelTema ."</b> impartida por <b>";
$mensaje .= $nombreDelTutor .".</b></p>";

$query = sprintf('insert into MensajesPrivados 
	(de,para,asunto,mensaje,fecha,leido) values(%d,%d,\'%s\',\'%s\',"%s",%s)',
	$de,$para,$asunto,$mensaje,$fecha,"false");

$mail = dameEmailDelUsuario($de,$db);

mail($mail,$asunto,$mensaje,HEADERS_MAIL);

if(! $db -> query($query)) echo ("Error al enviar mensaje de confirmacion");

$insert = sprintf("insert into Tutorias (estudiante,idTema) values(%d,%d);",
        $_GET['idTutorado'],$_GET['idTema']);

if(! $db->query($insert) ){
    $html = "<p>¡Ups!. La tutoría ya fue creada.</p>"; 
	print($html);
	exit();
}

$idTutoria = $db->insert_id;

saveMensaje($idTutoria,$de,1,1,"Etapa uno",$db);

$html = '<center><p style="margin-top:auto;margin-bottom">Tutoría creada. Direccionando en 3 seg...</p></center>'; 

$db->close();
print($html);
?>
