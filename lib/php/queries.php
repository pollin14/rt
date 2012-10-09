<?php

header('Content-Type: text/html; charset=UTF-8');

function dameNombreDelUsuario($idUsuario,$db){
	
	$query = sprintf("select nombre from Usuarios where idUsuario = %d;", $idUsuario);
	$result = $db-> query($query);
	if(!$result) 
		die ("Error al obtener el nombre del usuario.");
	$row = $result->fetch_assoc();
	return $row['nombre'];
}
function dameNombreDelTema($idTema,$db){
	$query = sprintf("select nombre from Temas where idTema = %d;", $idTema);
	$result = $db-> query($query);
	if(!$result) 
		die ("Error al obtener el nombre del tema. ");
	$row = $result->fetch_assoc();
	return $row['nombre'];
}

function dameNombreDelTutorDelTema($idTema,$db){
	$query = sprintf("
			select u.nombre as nombre
			from Usuarios as u,Temas as t 
			where 
				t.idTema = %d and 
				u.idUsuario = t.idUsuario;",$idTema);
	$result = $db -> query($query);
	if(!$result) die ("Error al obtener el nombre del tutor del tema.");
	$row = $result->fetch_assoc();
	return $row['nombre'];
}

function dameIdTemaIdAlumnoDeTutoria($idTutoria, $db){
	$result = $db -> query(sprintf("
		select idTema,estudiante from Tutorias 
		where idTutoria = %d;", $idTutoria));
	
	if(!$result ) 
		die("Error al obtener el id del tema y el id del alumo de la tutoria. ");
	
	return $result->fetch_row();
}

function dameNombreDelProducto($idProducto,$db){	
	$result = $db -> query(sprintf("
		select nombre from nombreDeProducto 
		where idProducto=  %d;", $idProducto));
	
	if(!$result) 
		die ("Error al obtener el nombre del producto.");
	
	$row = $result -> fetch_assoc();
	
	return $row['nombre'];
	
}

function dameNombreDelTemaDeLaTutoria($idTutoria,$db){
	$result = $db -> query ( sprintf("
		select Temas.nombre from Temas,Tutorias
		where Tutorias.idTutoria = %d and
			Tutorias.idTema = Temas.IdTema;",$idTutoria));
	
	if(!$result) 
		die ("Error al obtener el nombre del tema de la tutoria.");
	
	$row = $result -> fetch_assoc();
	
	return $row['nombre'];
}

function dameNombreDelTutorDeLaTutoria($idTutoria,$db){
	$query = sprintf('
			select Usuarios.nombre from Usuarios,Temas,Tutorias 
			where 
				Tutorias.idTutoria = %d and 
				Tutorias.idTema = Temas.idTema and
				Temas.idUsuario = Usuarios.idUsuario;',$idTutoria);
	$result = $db->query($query);
	
	if(!$result) 
		die ("Error al obtener el nombre del tutor de la tutoria.");
	
	$row = $result -> fetch_assoc();
	
	return $row['nombre'];
}

function dameNombreDelEstudiante($idTutoria,$db){
	$query = sprintf('
		select Usuarios.nombre 
			from Usuarios natural join Tutorias
			where 
				Tutorias.estudiante = Usuarios.idUsuario and
				Tutorias.idTutoria = %d;',$idTutoria);
	$result = $db->query($query);
	
	if(!$result) 
		die ("Errro al obtener el nombre del estudiante.");
	
	$row = $result -> fetch_assoc();
	
	return $row['nombre'];
}

function dameListaDeTutorias($idUsuario,$db){
	$query = sprintf(
		"select idTutoria from sinodales where idUsuario = %d;",$idUsuario);
	$result = $db->query($query);
	
	if(!$result) die ("Error al consultar las tutorias donde eres observador.");
	
	if($result->num_rows == 0)
		return false;
	
	$tmp = "(";
	while($row = $result->fetch_assoc()){
		$tmp .= $row['idTutoria'] . ",";
	}
	
	return substr($tmp, 0, strlen($tmp)-1) . ")";
}
?>
