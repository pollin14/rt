<?php
//mis tutorias.php ya incluye un include con configuracion.php
$db = dameConexion();

$query = sprintf(
		'select 
			idTutoria, 
			estudiante,
			tema 
			from misTutorias 
			where idTutor = %d;', $_SESSION['idUsuario']);

$result = $db->query($query);

if(!$result) die ('Error al obtener donde soy tutor(a)');

while($row = $result->fetch_assoc()){
	echo '<h2><a ';
	echo 'href="../tutorias/tutoria.php?idTutoria=' . $row['idTutoria'];
	echo '&tipoDeUsuario=tutor">';
	echo $row['tema'] . "</a></h2>";
	echo "<p>Tutorado: " . $row['estudiante'] . "</p>";
}

?>
