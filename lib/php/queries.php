<?php

header('Content-Type: text/html; charset=UTF-8');

function dameNombreDelUsuario($idUsuario,$db){
	
	$query = sprintf("select nombre from Usuarios where idUsuario = %d;", $idUsuario);
	$result = $db-> query($query);
	if(!$result) die ("error en la consulta: ".$query);
	$row = $result->fetch_assoc();
	return $row['nombre'];
}
function dameNombreDelTema($idTema,$db){
	$query = sprintf("select nombre from Temas where idTema = %d;", $idTema);
	$result = $db-> query($query);
	if(!$result) die ("error en la consulta: ".$query);
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
	if(!$result) die ("error en la consulta: ".$query);
	$row = $result->fetch_assoc();
	return $row['nombre'];
}

function dameIdTemaIdAlumnoDeTutoria($idTutoria, $db){
	
	$query = sprintf("
		select idTema,estudiante from Tutorias 
		where idTutoria = %d;", $idTutoria);
	
	$result = $db -> query($query);
	
	if(!$result ) die("Error. dameIdTemaIdAlumnoDeTutoria. " . $query . $db->error);
	
	return $result->fetch_row();
}

function dameNombreDelProducto($idProducto,$db){
	$result = $db -> query ("
		select nombre from nombreDeProducto 
		where idProducto= " . $idProducto .";" );
	
	if(!$result) 
		die ("Error al obtener el nombre del producto." .$query . $db->error);
	
	$row = $result -> fetch_assoc();
	
	return $row['nombre'];
	
}

function dameNombreDelTemaDeLaTutoria($idTutoria,$db){
	$result = $db -> query ("
		select Temas.nombre from Temas,Tutorias
		where Tutorias.idTutoria = " . $idTutoria ." and
			Tutorias.idTema = Temas.IdTema;");
	
	if(!$result) 
		die ("Error al obtener el nombre del producto." .$query . $db->error);
	
	$row = $result -> fetch_assoc();
	
	return $row['nombre'];
}

function dameNombreDelTutorDeLaTutoria($idTutoria,$db){
	$query = sprintf('
			select Usuarios.nombre from Usuarios,Temas,Tutorias 
			where 
				Tutorias.idTutoria = %d and 
				Tutorias.idTema = Temas.idTema and
				Temas.idUsuario = Usuarios.idUsuario;',$_GET['idTutoria']);
	$result = $db->query($query);
	
	if(!$result) 
		die ("Error al obtener el nombre del producto." .$query . $db->error);
	
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
		die ("Error al obtener el nombre del producto." .$query . $db->error);
	
	$row = $result -> fetch_assoc();
	
	return $row['nombre'];
}

function dameEmailDelUsuario($idUsuario,$db){
	$query = sprintf('select email from usuarios where idUsuario = %d;',$idUsuario);
	$result = $db -> query($query);
	if(!$result){
		return false;
	}else{
		$row = $result -> fetch_assoc();
		return $row['email'];
	}
}
?>
