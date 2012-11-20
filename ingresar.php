<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

include 'configuracion.php';


$nick = $_POST['nick'];
$contraseña = $_POST['contraseña'];
$idUsuario = "";
$db = dameConexion();

$buscaUsuario = sprintf("select idUsuario,nombre 
	from Usuarios where nick='%s' and contraseña ='%s';",$nick,$contraseña);
$result = $db->query($buscaUsuario);

if(!$result) die($buscaUsuario . " - " . $db->error . '+' .$db->errno);

if($result -> num_rows == 0) die ( "Error1, no existe el usuario o la constraseña es incorrecta");

$row = $result -> fetch_assoc();

if(!$row) die ( "Error2, no existe el usuario o la constraseña es incorrecta");

$_SESSION['idUsuario'] = $row['idUsuario'];
$_SESSION['nick'] = $nick;
$_SESSION['nombre'] = $row['nombre'];
print ("exito");
$db ->close();
?>