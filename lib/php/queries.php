<?php

function dameNombreDelUsuario($idUsuario, $db) {

	$query = sprintf("select nombre from Usuarios where idUsuario = %d;", $idUsuario);
	$result = $db->query($query);
	if (!$result)
		die("Error al obtener el nombre del usuario.");
	$row = $result->fetch_assoc();
	return $row['nombre'];
}

function dameNombreDelTema($idTema, $db) {
	$query = sprintf("select nombre from Temas where idTema = %d;", $idTema);
	$result = $db->query($query);
	if (!$result)
		die("Error al obtener el nombre del tema. ");
	$row = $result->fetch_assoc();
	return $row['nombre'];
}

function dameNombreDelTutorDelTema($idTema, $db) {
	$query = sprintf("
			select u.nombre as nombre
			from Usuarios as u,Temas as t 
			where 
				t.idTema = %d and 
				u.idUsuario = t.idUsuario;", $idTema);
	$result = $db->query($query);
	if (!$result)
		die("Error al obtener el nombre del tutor del tema.");
	$row = $result->fetch_assoc();
	return $row['nombre'];
}

function dameIdTemaIdAlumnoDeTutoria($idTutoria, $db) {
	$result = $db->query(sprintf("
		select idTema,estudiante from Tutorias 
		where idTutoria = %d;", $idTutoria));

	if (!$result)
		die("Error al obtener el id del tema y el id del alumo de la tutoria. ");

	return $result->fetch_row();
}

function dameNombreDelProducto($idProducto, $db) {
	$result = $db->query(sprintf("
		select nombre from nombreDeProducto 
		where idProducto=  %d;", $idProducto));

	if (!$result)
		die("Error al obtener el nombre del producto.");

	$row = $result->fetch_assoc();

	return $row['nombre'];
}

function dameNombreDelTemaDeLaTutoria($idTutoria, $db) {
	$result = $db->query(sprintf("
		select Temas.nombre from Temas,Tutorias
		where Tutorias.idTutoria = %d and
			Tutorias.idTema = Temas.IdTema;", $idTutoria));

	if (!$result)
		die("Error al obtener el nombre del tema de la tutoria.");

	$row = $result->fetch_assoc();

	return $row['nombre'];
}

function dameNombreDelTutorDeLaTutoria($idTutoria, $db) {
	$query = sprintf('
			select Usuarios.nombre from Usuarios,Temas,Tutorias 
			where 
				Tutorias.idTutoria = %d and 
				Tutorias.idTema = Temas.idTema and
				Temas.idUsuario = Usuarios.idUsuario;', $idTutoria);
	$result = $db->query($query);

	if (!$result)
		die("Error al obtener el nombre del tutor de la tutoria.");

	$row = $result->fetch_assoc();

	return $row['nombre'];
}

function dameNombreDelEstudiante($idTutoria, $db) {
	$query = sprintf('
		select Usuarios.nombre 
			from Usuarios natural join Tutorias
			where 
				Tutorias.estudiante = Usuarios.idUsuario and
				Tutorias.idTutoria = %d;', $idTutoria);
	$result = $db->query($query);

	if (!$result)
		die("Errro al obtener el nombre del estudiante.");

	$row = $result->fetch_assoc();

	return $row['nombre'];
}

function dameListaDeTutorias($idUsuario, $db) {
	$query = sprintf(
			"select idTutoria from sinodales where idUsuario = %d;", $idUsuario);
	$result = $db->query($query);

	if (!$result)
		die("Error al consultar las tutorias donde eres observador.");

	if ($result->num_rows == 0)
		return false;

	$tmp = "(";
	while ($row = $result->fetch_assoc()) {
		$tmp .= $row['idTutoria'] . ",";
	}

	return substr($tmp, 0, strlen($tmp) - 1) . ")";
}

function dameResumen($db) {

	function inicializaFila(&$fila, $entidad) {
		$fila['Entidad'] = $entidad;
		$fila['Español'] = 0;
		$fila['Ciencias'] = 0;
		$fila['Matemáticas'] = 0;
		$fila['null'] = 0; //Sin asignatura
	}

	$query = '
		select
			entidad,
			asignatura,
			count(entidad) as temas
		from
			(select entidad,asignatura,idTema from view_temas group by asignatura,idTema) as x
		group by entidad, asignatura
		order by entidad';

	$entidad = "";
	$tabla = array();

	$result = $db->query($query);

	while ($result && $row = $result->fetch_assoc()) {

		if ($row['entidad'] != $entidad) {
			$entidad = $row['entidad'];
			inicializaFila($tabla[$row['entidad']], $row['entidad']);
		}

		if ($row['asignatura'] === null) {
			$row['asignatura'] = "null";
		}
		$tabla[$row['entidad']][$row['asignatura']] = $row['temas'];
	}

	return $tabla;
}

?>
