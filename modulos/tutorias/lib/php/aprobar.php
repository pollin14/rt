<?php

header('Content-Type: text/html; charset=UTF-8');
include "../../../../configuracion.php";
include "../../../../lib/php/queries.php";

$db = dameConexion();

$t = dameIdTemaIdAlumnoDeTutoria($_POST['idTutoria'],$db);
$idTema = $t[0];
$idAlumno = $t[1];
$query = sprintf("update Temas set autorizado = true 
	where idUsuario = %d and temaPadre = %d;", $idAlumno,$idTema);

if(!$db -> query($query)){
	echo "Error al autorizar tema.";
	$db->close();
	exit();
}

echo "El Demostrador ya apuede tutorar en este tema.";

$db->close();
?>
