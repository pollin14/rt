<?php
//mis tutorias.php ya incluye un include con configuracion.php
$db = dameConexion();

$query = sprintf(
		'select 
			idTutoria, 
			tutor,
			tema 
			from misTutorias 
			where idEstudiante= %d;', $_SESSION['idUsuario']);

$result = $db->query($query);

while($result && $row = $result->fetch_assoc()){
	echo '<h2><a ';
	echo 'href="../tutorias/tutoria.php?idTutoria=' . $row['idTutoria'];
	echo '&tipoDeUsuario=alumno">';
	echo $row['tema'] . "</a></h2>";
	echo "<p>Tutor: " . $row['tutor'] . "</p>";
}

?>
