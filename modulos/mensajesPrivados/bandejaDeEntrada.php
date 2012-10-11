<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include "../../configuracion.php";
administraSesion();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <title>Bandeja De Entrada</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link type="text/css" rel="StyleSheet" href="bandejaDeEntrada.css"/>
		<link rel="stylesheet" type="text/css" href="../../lib/css/style.css"/>
        <script type="text/javascript" src="../../lib/js/funciones.js"></script>
        <script type="text/javascript" src="../../lib/js/jquery.js"></script>
        <script type="text/javascript" src="bandejaDeEntrada.js"></script>
    </head>

	<body>

		<div id="wrapper">

			<div id="header">

			</div>

			<div id="menu">
				<ul>
					<li><a href="../loged/loged.php" name="home">Inicio</a></li>
					<li><a href="bandejaDeEntrada.php" name="bandejaDeEntrada">Bandeja De Entrada</a></li>
					<li><a href="../misTutorias/misTutorias.php" name="misTutorias">Mis Tutorias</a></li>
					<li><a href="../solicitudDeTutoria/solicitudDeTutoria.php" name="solicitudDeTutoria">Solicitud de Tutoria</a></li>
					<li><a href="../alta_en_arbol/index.php?uid=<?php echo $_SESSION['idUsuario']; ?>" name="misTemasDeCatalogo">Temas de Catalogo</a></li>
				</ul>
			</div>

			<div id="sidebar">
				<div id="feed">
					<a class="feed-button" href="../../modulos/loged/cerrarSesion.php">Cerrar Sesion</a>
				</div>

				<div id="misDatos">
					<p><?php echo $_SESSION['nombre']; ?></p>
					<?php
					$imagen = $_SESSION['idUsuario'] . ".jpg";

					if (!file_exists("../../avatares/" . $imagen)) {
						$imagen = "default.jpg";
					}

					echo '<img src="../../avatares/' . $imagen . '"';
					echo ' alt="Click para subir un nuevo avatar."';
					echo ' onclick=\'window.open("../../lib/subirArchivo/subirArchivo.html","SubirAvatar","height=200px,width=600px,location=no,menubar=no,resizable=no,scollbars=no,titlebar=no,toolbar=no")\'/>';
					?>
				</div>

				<div id="sidebar-bottom"></div>
			</div>

			<div id="content">
<!--				<div id="ad-top">
					Insert 468x60 banner advertisement 
				</div>-->

				<p id="barraDeNavegacion"></p>
				<div id="actualizar"><a>Actualizar</a></div>
				<div id="bandejaDeEntrada"></div>
				<div id="mensaje"></div>
				<div style="clear:both;"></div>

			</div>

			<div id="footer">
				<div id="footer-valid">
					Av. Paseo de la Reforma 122, Col. Juárez, Delegación Cuauhtémoc, C.P. 06600, México, D.F
				</div>
			</div>

		</div>

	</body>
</html>
