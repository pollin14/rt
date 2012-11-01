<?php
//mis tutorias.php ya incluye un include con configuracion.php y queries.php
$db = dameConexion();
$tutorias = dameListaDeTutorias($_SESSION['idUsuario'],$db);

if( $tutorias ){
	$query = sprintf(
		'select idTutoria,tutor,estudiante,tema from misTutorias where idTutoria in %s;', $tutorias );

	$result = $db->query($query);

	if(!$result) die ("Error al buscar donde eres observador");

	while($row = $result->fetch_assoc()){
		echo '<h2><a ';
		echo 'href="../tutorias/tutoria.php?idTutoria=' . $row['idTutoria'];
		echo '&tipoDeUsuario=observador">';
		echo $row['tema'] . "</a></h2>";
		echo "<p>Tutor: " . $row['tutor'] . "</p>";
		echo "<p>Tutorado: " . $row['estudiante'] . "</p>";
	}
}


?>