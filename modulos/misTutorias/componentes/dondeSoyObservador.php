<?php
//mis tutorias.php ya incluye un include con configuracion.php y queries.php
$db = dameConexion();

$idTutoria = dameIdTutoriaDelSinodal($_SESSION['idUsuario'],$db);

$query = sprintf(
		'select tutor,estudiante,tema from misTutorias where idTutoria = %d;',$idTutoria);

$result = $db->query($query);

if(!$result) die ("Error al buscar donde eres observador");
	
while($row = $result->fetch_assoc()){
	echo '<h2><a ';
	echo 'href="../tutorias/tutoria.php?idTutoria=' . $idTutoria;
	echo '&tipoDeUsuario=Observador">';
	echo $row['tema'] . "</a></h2>";
	echo "<p>Tutor: " . $row['tutor'] . "</p>";
	echo "<p>Tutorado: " . $row['estudiante'] . "</p>";
}



?>