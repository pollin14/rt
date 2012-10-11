<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Alta de Usuarios</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<link rel="StyleSheet" href="lib/css/style.css" type="text/css"/>
			<script type="text/javascript" src="lib/js/jquery.js"></script>
			<script type="text/javascript" src="lib/js/funciones.js"></script>
			<script type="text/javascript" src="lib/js/login.js"></script>
	</head>

	<body>

		<div id="wrapper">

			<div id="header">

			</div>

			<div id="content">
				<div class="center">
					<p><?php include "lib/php/nombreDelProyecto.php" ?> es una Plataforma de apoyo a las tutorías a distancia, ofreciendo herramientas de comunicación a tutores e interesados en adquirir conocimientos por medio de tutorías</p>
					<form id="form1">
						<table class="shadow">
							<tr>
								<td colspan="2"><p><strong>Ingreso a la plataforma</strong></p>
									<br />
								</td>
							</tr>
							<tr>
								<td>Usuario</td>
								<td>
									<label for="User"></label>
									<input type="text" name="User" id="usuario" />
								</td>
							</tr>
							<tr>
								<td>Contraseña</td>
								<td><input type="password" name="password" id="contraseña" /></td>
							</tr>
							<tr>
								<td height="55"></td>
								<td><input type="button" name="ingreso" id="ingreso" value="ingresar" /></td>
							</tr>
							<tr>
								<td colspan="2" align="right"><a href="modulos/registro/index.php" title="Alta en ESVIAP">No estoy registrado</a></td>
							</tr>
							<tr>
								<td colspan="2" align="right"><a href="lib/php/recuperacionDeContrasena.php" title="Recuperar Correo" target="_blank">Recuperar Contraseña</a></td>
							</tr>
						</table>
					</form>
					<a href="Privacidad.php">Política  de privacidad y manejo de datos personales</a><a href="modulos/estadisticas/estadisticas.php">.</a>
				</div>
			</div>

			<div id="footer">
				<div id="footer-valid">
					<?php include '../../lib/php/direccion.php' ?>
				</div>
			</div>

		</div>

	</body>
</html>
