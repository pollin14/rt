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


/*
 * 
 * Con el siguete select se crea la vista para realizar las cosultas.
select 
	tutorias.idTutoria as idTutoria,
	tutorias.idTema as idTema,
	temas.nombre as tema,
	temas.idUsuario as idTutor,
	x.nombre as tutor,
	tutorias.estudiante as idEstudiante,
	y.nombre as estudiante
from 
	(((tutorias
		left join temas on temas.idTema = tutorias.idTema)
			left join usuarios as x on x.idUsuario = temas.idUsuario)
				left join usuarios as y on y.idUsuario = tutorias.estudiante);

 */
?>
