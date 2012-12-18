<?php

header('Content-Type: text/html; charset=UTF-8');
include 'configuracion.php';

$error = "";

session_start();

if (isset($_SESSION['idUsuario'])) {
	header('location: modulos/loged/loged.php');
}


//redireccion a la pagina que se solicito.
if( isset($_GET['pa'])){
	$pa = "?pa=" . $_GET['pa'];
}else{
	$pa = '';
}

if (isset($_POST['nickname']) &&
		isset($_POST['password'])) {

	$nick = $_POST['nickname'];
	$contraseña = $_POST['password'];
	$db = dameConexion();

	$buscaUsuario = sprintf("select idUsuario,nombre 
	from Usuarios where nick='%s' and contraseña ='%s';", $nick, $contraseña);
	$result = $db->query($buscaUsuario);

	if (!$result) {
		$error = "Ups! Ocurrio un problema al conectarse con la base de datos.";
	} else {

		if ($result->num_rows == 0) {
			$error = 'El usuario o la constraseña son incorrecta.';
		} else {
			$row = $result->fetch_assoc();

			$_SESSION['idUsuario'] = $row['idUsuario'];
			$_SESSION['nick'] = $nick;
			$_SESSION['nombre'] = $row['nombre'];
			
			if( isset($_GET['pa'])){
				$dir = $_GET['pa'];
			}else{
				$dir = "/" . SITE_ROOT . 'modulos/loged/loged.php';
			}
			header('location: http://' . $_SERVER['SERVER_NAME'] .  $dir);
		}
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Espacio Virtual de Aprendizaje</title>
		<link rel="stylesheet" type="text/css" href="lib/css/esviap.css" />


	</head>

	<body>
		<p align="center"><img src="lib/img/eimle.png"alt="logo ESVIAP" /></p>

		<table height="429" align="center" width="600px">
			<tr>
				<td height="401" align="center" valign="top">

					<p></p>
					<p class="azul1_0">TURed es una Plataforma de apoyo a las tutorías a distancia, ofreciendo herramientas de comunicación a tutores e interesados en adquirir conocimientos por medio de tutorías</p>
					<p></p>
					<form id="ingreso" method="post" action="index.php<?php echo $pa ?>" >
						<table>
							<tr>
								<th colspan="2">Ingreso a la plataforma</th>
							</tr>
							<tr>
								<td colspan="2" class="error"><?php echo $error ?></td>
							</tr>
							<tr id="nickname">
								<td><label for="nickname">Usuario</label></td>
								<td>
									<input type="text" name="nickname" autofocus />
								</td>
							</tr>
							<tr id="password">
								<td><label for="password">Contraseña</label></td>
								<td><input type="password" name="password" /></td>
							</tr>
							<tr>
								<td colspan="2"><input type="submit" class="submit" value="Ingresar" /></td>
							</tr>
							<tr>
								<td colspan="2"><a href="modulos/registro/index.php" title="Alta en ESVIAP">No estoy registrado</a></td>
							</tr>
							<tr>
								<td colspan="2" class="right"><a href="modulos/recuperacionDeContrasena/recuperacionDeContrasena.php" title="Recuperar Correo">Recuperar Contraseña</a></td>
							</tr>
						</table>
					</form>
					<p></p>
					<p><strong><a href="Privacidad.php">Política  de privacidad y manejo de datos personales</a><a href="modulos/estadisticas/estadisticas.php">.</a></strong></p>
					<tr><td valign="top" height="20">
							<?php include "lib/php/pieDePagina.php" ?>
						</td></tr></table>
					</body>
					</html>
