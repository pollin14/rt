<?php

header('Content-Type: text/html; charset=UTF-8');
include "../../configuracion.php";

$db = dameConexion();

if($_POST['tipo'] == "producto"){
	$tabla = "Productos";
}else{
	$tabla = "Recursos";
}

$query = sprintf('delete from ' . $tabla .
        ' where url = "%s"',$_POST['url']);

if ( !$db->query($query) ){
    echo "Error: " . $query;
}else{
    echo "exito";
}
?>
