<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include "../../configuracion.php";
administraSesion();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Solicitud de Tutoria</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link type="text/css" href="lib/css/solicitudDeTutoria.css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="../../lib/css/style.css"/>
        <script type="text/javascript" src="../../lib/js/jquery.js"></script>
        <script type="text/javascript" src="../../lib/js/funciones.js"></script>
        <script type="text/javascript" src="lib/js/solicitudDeTutoria.js"></script>
	</head>

	<body>

		<div id="wrapper">

			<div id="header">

			</div>

			<div id="menu">
				<ul>
					<li><a href="../loged/loged.php" name="home">Pagina de Inicio</a></li>
					<li><a href="../mensajesPrivados/bandejaDeEntrada.php" name="bandejaDeEntrada">Bandeja De Entrada</a></li>
					<li><a href="../misTutorias/misTutorias.php" name="misTutorias">Mis Tutorias</a></li>
					<li><a href="solicitudDeTutoria.php" name="solicitudDeTutoria">Solicitud de Tutoria</a></li>
					<li><a href="../alta_en_arbol/index.php?uid=<?php echo $_SESSION['idUsuario']; ?>" name="misTemasDeCatalogo">Temas de Catalogo</a></li>
				</ul>
			</div>

			<div id="sidebar">
				<div id="feed">
					<a class="feed-button" href="cerrarSesion.php">Cerrar Sesion</a>
				</div>

				<div id="misDatos">
					<p><?php echo $_SESSION['nombre']; ?></p>
					<?php
					$imagen = $_SESSION['idUsuario'] . ".jpg";

					if (!file_exists("../../avatares/" . $imagen)) {
						$imagen = "default.jpg";
					}

					echo '<img src="../../avatares/' . $imagen . '"';
					echo 'alt="Click para subir un nuevo avatar." />';
					?>
				</div>

				<div id="sidebar-bottom"></div>
			</div>

			<div id="content">
				<div id="ad-top">
					<!--					 Insert 468x60 banner advertisement -->
				</div>

				<div id="lista1">
					<h3>Componente/Eje/Categoria</h3>
					<select size="10">
					</select>
				</div>
				<div id="lista2">
					<h3>Estandares</h3>
					<select size="10">
					</select>
				</div>
				<div id="lista3">
					<h3>Catálogo</h3>
					<select size="10">
					</select>
				</div>
				<div id="lista4">
					<h3>Tutores</h3>
					<select size="10">
					</select>
				</div>

				<div id="enviarSolicitud">
					<button type="button" value="Enviar Solicitud" >Enviar Solicitud</button>
				</div>
				<div style="clear:both"></div>
				<div id="m"></div>

			</div>

			<div id="footer">
				<div id="footer-valid">
					Av. Paseo de la Reforma 122, Col. Juárez, Delegación Cuauhtémoc, C.P. 06600, México, D.F
				</div>
			</div>

		</div>

	</body>
</html>
