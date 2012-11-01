<?php

header('Content-Type: text/html; charset=UTF-8');
include "../../../../configuracion.php";
include "../../../../lib/php/utils.php";

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

while($result && $row = $result->fetch_assoc()){
	$visual = ($row['descripcion'] == "")? dameNombreDelArchivo($row['url']): $row['descripcion'];
	echo '<div class="itemlist">';
	echo '<img src="../../lib/img/cancel.png" title="Borrar Recurso"/>';
	echo '<p value="' . $row['url'] . '" title="' . $row['hint'] . '">';
	echo $visual.'</p>';
	echo '</div>';
}
?>
