<?php 
session_start();
header('Content-Type: text/html; charset=UTF-8');
include "../../configuracion.php";
administraSesion();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>TURed</title>
		<link rel="stylesheet" href="../../lib/css/style.css" type="text/css" media="screen" />
		<link rel="StyleSheet" href="misTutorias.css" type="text/css"/>
		<script type="text/javascript" src="../../lib/js/jquery.js"></script>
		<script type="text/javascript" src="loged.js"></script>
		<script type="text/javascript" src="misTutorias.js"></script>
	</head>

	<body>

		<div id="wrapper">

			<div id="header">
				
			</div>

			<div id="menu">
				<ul>
					<li value="..loged/loged.php"><a href="../loged/loged.php" name="home">Pagina de Inicio</a></li>
					<li><a href="../mensajesPrivados/bandejaDeEntrada.php" name="bandejaDeEntrada">Bandeja De Entrada</a></li>
					<li><a href="misTutorias.php" name="misTutorias">Mis Tutorias</a></li>
					<li><a href="../solicitudDeTutoria/solicitudDeTutoria.php" name="solicitudDeTutoria">Solicitud de Tutoria</a></li>
					<li><a href="../alta_en_arbol/index.php" name="misTemasDeCatalogo">Temas de Catalogo</a></li>
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

						if( !file_exists("../../avatares/".$imagen)){
							$imagen = "default.jpg";
						}

						echo '<img src="../../avatares/' .$imagen .'"';
						echo 'alt="Click para subir un nuevo avatar." />';
					?>
				</div>
				
				<div id="sidebar-bottom"></div>
			</div>

			<div id="content">
				<div id="ad-top">
<!--					 Insert 468x60 banner advertisement -->
				</div>
				
				<div id="menu-vertical">
					<ul>
					   <li title="buscaTutorias">Mis Tutorías</li>
					   <li title="buscaTutorados">¿Donde soy Tutorado?</li>
					   <li title="buscaDondeSoyObservador">¿Donde soy Observador? </li>
					</ul>
				 </div>
				 <div id="contenido"></div>
				
			</div>

			<div id="footer">
				<div id="footer-valid">
					Av. Paseo de la Reforma 122, Col. Juárez, Delegación Cuauhtémoc, C.P. 06600, México, D.F
				</div>
			</div>

		</div>

	</body>
</html>
