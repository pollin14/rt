<?php
header('Content-Type: text/html; charset=UTF-8');
include "../../configuracion.php";
include "../../lib/php/utils.php";

$idTutoria = $_POST['idTutoria'];
$asunto = "Solicitud de Observador";
$mensaje = "
<html>
    <head>
        <title></title> 
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
    </head>
    <body>";

$mensaje .= "<h3> Solicitud De Observador</h3>";
$mensaje .= "<p>Nos complace el anunciarte, que has sido seleccionado 
	por la red de tutoría EIMLE como Observador";

$fecha = getActualDate();

$db = dameConexion();

//comprobamos conexion;
if($db->connect_errno){
  printf($db->connect_error);
  exit();
}

$delete = sprintf("delete from Sinodales where idTutoria = %d;",$idTutoria);

if(!$db->query($delete))die("Error." . $db->error);

$buscaTema= sprintf("
    select 
		Temas.nombre, 
		Temas.idTema,
		Temas.idUsuario as idTutor,
		Tutorias.estudiante as idEstudiante,
		Usuarios.nombre as nombreDelTutor,
		Usuarios.email as correoDelTutor
		from Tutorias, Temas, Usuarios
	where 
		Tutorias.idTutoria = %d and
		Usuarios.idUsuario = Temas.idUsuario and
		Temas.idTema = Tutorias.idTema;", $idTutoria);

$result =  $db->query($buscaTema);
$row = $result->fetch_assoc();

$nombreDelTema = $row['nombre'];
$idTema=$row ['idTema'];
$idAlumno = $row['idEstudiante'];
$idTutor = $row['idTutor'];
$nombreDelTutor = $row['nombreDelTutor'];
$correoDelTutor = $row['correoDelTutor'];

$query = sprintf("select nombre,email from Usuarios where idUsuario = %d;", $idAlumno);
$result = $db->query($query);
$row = $result -> fetch_assoc();

$nombreDelAlumno = $row['nombre'];
$correoDelAlumno = $row['email'];

$result->free();

$mensaje .= " para la demostración de <b>" .$nombreDelAlumno ."</b>"; 
$mensaje .= " (<b>".$correoDelAlumno . "</b>)";
$mensaje .= " en el tema <b>".$nombreDelTema."</b>";
$mensaje .= " que es impartido por <b>" .$nombreDelTutor ."</b>";
$mensaje .= "(<b>". $correoDelTutor . "</b>)";
$mensaje .= " e inpacta a los siguientes términos: </p>";

$buscaEstandar = sprintf("
	select * from EstandaresDeTema 
	where idTema=%d;", $idTema);
$result = $db->query($buscaEstandar);

if (!$result) die("Error. " . $buscaEstandar . $db->error);

while ( $row = $result -> fetch_assoc()){

    $idEstandar= $row['idEstandar'];

	$buscaInpacto = sprintf("
	select

		Asignaturas.nombre                    as asignatura, 
		ComponenteEjeCategoria.nombre         as componente, 
		Periodos.nombre                       as periodo,
		Estandares.descripcion                as estandar

	from     

		Asignaturas, ComponenteEjeCategoria,Estandares,Periodos

	where 
		Asignaturas.idAsignatura = Estandares.idAsignatura and 
		ComponenteEjeCategoria.idComponenteEjeCategoria = Estandares.idComponenteEjeCategoria and 
		Periodos.idPeriodo = Estandares.idPeriodo and
		Estandares.idEstandar = %d;", $idEstandar);

	$resultadoDeInpacto = $db->query($buscaInpacto);

	$filaDeInpacto = $resultadoDeInpacto -> fetch_assoc();

	$asignatura= $filaDeInpacto['asignatura'];
	$componente= $filaDeInpacto['componente'];
	$periodo = $filaDeInpacto['periodo'];
	$estandar = $filaDeInpacto['estandar'];
	
	$mensaje .= "<p>";
	$mensaje .= "Periodo: <b>".$periodo.".</b><br/>";
	$mensaje .= "Asignatura: <b>".$asignatura.".</b><br/>";
	$mensaje .= "Componente: <b>".$componente.".</b><br/>";
	$mensaje .= "Estándar: <b>".$estandar.".</b><br/>";
	$mensaje .= "</p>";

}

$mensaje .= "<p>Le sugerimos las siguientes fechas: </p>";
$mensaje .= "<ul><li>2012-08-25 18:00 </li>";
$mensaje .= "<li>2012-08-24 18:00 </li>";
$mensaje .= "<li>2012-08-23 18:00 </li></ul>";



$mensaje .= "<p>Favor de consultar los siguientes productos de la tutoria:</p>";

$buscaProductos=  sprintf("select 
    Productos.url           as url,
	Productos.hint			as hint,
    Productos.descripcion   as descripcion
    from                    Productos 
    natural join            Tutorias 
    where                   Tutorias.idTutoria=%d;",$idTutoria);

$result = $db->query($buscaProductos);

if(!$result) die('Error.' . $db->error);

while ($row = $result -> fetch_assoc()){
	$visual = ($row['descripcion'] == "")? $row['url']: $row['descripcion'];
    $mensaje .= '<a href="' . $row['url'] . '"';
	$mensaje .= ' title="' . $row['hint'] . '">';
	$mensaje .= $visual . '</a>';
	$mensaje .= "<br><br>";
}

$mensaje .= "<p>Favor de contactar al estudiante <b>".$nombreDelAlumno;
$mensaje .= "</b> en el correo: <b>".$correoDelAlumno . '</b></p>';
$mensaje .= "<p>Gracias.</p>";
$mensaje .= " </body></html>";


$ldo = "<ul>";

$buscaObservadores= sprintf("
	select * from Usuarios
	where idUsuario not in (%d,%d)
	order by rand() limit 3;", $idAlumno,$idTutor);

$result = $db->query($buscaObservadores);

if(!$result) die("Error." . $query . $db->error);

while( $row = $result->fetch_assoc()){
	
	$idObservador = $row['idUsuario'];
	$nombre = $row['nombre'];
	$correo = $row['email'];
    
	$ldo .= "<li>".$nombre ." : <b>" . $correo . "</b></li>";

	$query = sprintf("insert into Sinodales (idTutoria,idUsuario)
		values (%d,%d);",$idTutoria,$idObservador);
	
	if(! $db->query($query) ) die("Error." . $query . $db->error);
    
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf8\r\n";
	$headers .= "From: Red de Tutorias (RT)\r\n";
	$headers .= "Reply-To: no-reply\r\n";
	
    //mail($correoDeSinodal,$asunto,$mensaje,$headers);
    $query = sprintf('insert into 
        MensajesPrivados (de,para,asunto,mensaje,fecha) values(%d,%d,"%s",\'%s\',"%s");',
            $idAlumno,$idObservador,$asunto,$mensaje,$fecha);
	
	$db -> query($query);
	
	if(!$db)die("Error. " . $query . $db->error);	
}

$ldo .= "</ul>";

//Mensaje para el futuro Demostrador
$asunto = "Asignación de Observadores";

$mensaje = "<h3>Asignación de Observadores</h3>";
$mensaje .= "<p>Los Observadores seleccionados para tu Demostración";
$mensaje .= " del tema <b>" . $nombreDelTema ."</b>";
$mensaje .= " impartido por <b>" .$nombreDelTutor ."</b>" ;
$mensaje .= " (<b>".$correoDelTutor ."</b>)";
$mensaje .= " son</p> " .$ldo ."";
$mensaje .= "<p>Contactate con ellos y con el tutor para acordar la fecha y hora de la";
$mensaje .= " Demostración.</p>";

$query = sprintf('
	insert into MensajesPrivados (de,para,asunto,mensaje,fecha)
	values (%d,%d,"%s",\'%s\',"%s");',$idTutor,$idAlumno,$asunto,$mensaje,$fecha);

if(!$db -> query($query)) die("Error." . $query . $db->error);

//Mensaje para el Tutor
$asunto = "Asignación de Observadores";

$mensaje = "<h3>Asignación de Observadores</h3>";
$mensaje .= "<p>Los Observadores seleccionados para la Demostración";
$mensaje .= " del Tema <b>" . $nombreDelTema ."</b> que impartes a <b>";
$mensaje .= $nombreDelAlumno . "</b>";
$mensaje .= "(<b>".$correoDelAlumno ."</b>)";
$mensaje .= " son " .$ldo ."</p>";
$mensaje .= "<p>Contactate con ellos y con el tutor para acordar la fecha y hora de la";
$mensaje .= " Demostración.</p>";

$query = sprintf('
	insert into MensajesPrivados (de,para,asunto,mensaje,fecha)
	values (%d,%d,"%s",\'%s\',"%s");',$idAlumno,$idTutor,$asunto,$mensaje,$fecha);

if (!$db->query($query))die("Error. " .$query . $db->error);

$db->close();

?>
