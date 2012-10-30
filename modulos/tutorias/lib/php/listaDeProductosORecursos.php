<?php

header('Content-Type: text/html; charset=UTF-8');
include "../../../../configuracion.php";
include "../../../../lib/php/utils.php";

function dameIcono($extension){
	$tipo = "ext";
	
	if ( strpos('pdf',$extension) !== false ) $tipo = 'pdf';
	if ( strpos('odt,docx',$extension) !== false ) $tipo = 'doc';
	if ( strpos('png',$extension) !== false ) $tipo = 'png';
	if ( strpos('jpg,jpeg,gif,bmp,jpe,tiff',$extension) !== false ) $tipo = 'png';
	if ( strpos('ods,xlsx',$extension) !== false ) $tipo = 'xls';
	if ( strpos('odp,pptx',$extension) !== false ) $tipo = 'ppt';
	if ( strpos('zip,rar,tar,gp,gz',$extension) !== false ) $tipo = 'zip';
	
	return $tipo;
}


if(isset($_POST['r'])){
	$query = sprintf("select * from Recursos 
		natural join Tutorias
		where idTutoria = %d;",$_POST['idTutoria']);
}else{
	$query = sprintf("select * from Productos 
		where idTutoria = %d;",$_POST['idTutoria']);
}

$db = dameConexion();

// Obtenemos los recursos
$result = $db->query($query);

if ( ! $result){
	echo "Ups! Ocurrió un problema al abtener los productos o recursos.";
}

$paridad = 'filaPar';

while($result && $row = $result->fetch_assoc()){
	$visual = ($row['descripcion'] == "")? dameNombreDelArchivo($row['url']): $row['descripcion'];
	$extension = dameExtension(dameNombreDelArchivo($row['url']));
	$extension = substr($extension, 1, strlen($extension)-1);
	
	$tipo = dameIcono($extension);
	
	if($paridad === 'filaPar')
		$paridad = 'filaImpart';
	else
		$paridad = 'filaPar';
	
	echo '<div class="' . $paridad . '">';
	echo '<span ';
	echo 'style="background-image:url(\'lib/css/img/'. $tipo .'.png\');" ';
	echo 'value="' . $row['url'] . '" title="' . $row['hint'] . '">';
	echo $visual.'</span>';
	echo '<img src="../../lib/img/cancel.png" title="Borrar Recurso"/>';
	echo '</div>';
	echo '<span style="clear:both;display:none;"></span>';
}
?>
