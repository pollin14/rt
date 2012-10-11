<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include "../../configuracion.php";
include "../../lib/php/queries.php";
administraSesion();

$db = dameConexion();
$nombreDelTema = dameNombreDelTemaDeLaTutoria($_GET['idTutoria'], $db);

switch ($_GET['tipoDeUsuario']) {
	case ("alumno"):
		$nombreDelOtro = dameNombreDelTutorDeLaTutoria($_GET['idTutoria'], $db);
		$otros = "Tutor: " . $nombreDelOtro;
		break;
	case("demostrador"):
		$nombreDelOtro = dameNombreDelTutorDeLaTutoria($_GET['idTutoria'], $db);
		$otros = "Moderador: " . $nombreDelOtro;
		break;
	case("tutor"):
		$nombreDelOtro = dameNombreDelEstudiante($_GET['idTutoria'], $db);
		$otros = "Tutorado: " . $nombreDelOtro;
		break;
	case("moderador"):
		$nombreDelOtro = dameNombreDelEstudiante($_GET['idTutoria'], $db);
		$otros = "Demostrador: " . $nombreDelOtro;
		break;
	default:
		$otros = "Observador/Sinodal";
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Tutorias:

			<?php
			echo $_GET['tipoDeUsuario'];
			?>

		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<link rel="StyleSheet" href="../../lib/css/style.css" type="text/css"/>
			<link rel="StyleSheet" href="lib/css/chat.css" type="text/css"/>

			<script type="text/javascript" src="../../lib/js/jquery.js"></script>
			<script type="text/javascript" src="../../lib/js/funciones.js"></script>
			<script type="text/javascript" src="../../lib/js/modernizr.js"></script>
			<script type="text/javascript" src="lib/js/chat.js"></script>
	</head>

	<body>

		<div id="wrapper">

			<div id="header">

			</div>

			<div id="menu">
				<ul>
					<li><a href="../../modulos/loged/loged.php" name="home">Inicio</a></li>
					<li><a href="../../modulos/mensajesPrivados/bandejaDeEntrada.php" name="bandejaDeEntrada">Bandeja De Entrada</a></li>
					<li><a href="../../modulos/misTutorias/misTutorias.php" name="misTutorias">Mis Tutorias</a></li>
					<li><a href="../../modulos/solicitudDeTutoria/solicitudDeTutoria.php" name="solicitudDeTutoria">Solicitud de Tutoria</a></li>
					<li><a href="../alta_en_arbol/index.php?uid=<?php echo $_SESSION['idUsuario']; ?>" name="misTemasDeCatalogo">Temas de Catalogo</a></li>
				</ul>
			</div>

			<div id="sidebar">
				<div id="feed">
					<a class="feed-button" href="../../lib/php/cerrarSesion.php">Cerrar Sesion</a>
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
				<?php
				$tipoDeUsuario = $_GET['tipoDeUsuario'];

				switch ($tipoDeUsuario) {
					case ("moderador"): // Es el tutor en etapa de demostracion
						include "componentes/mensajesPendientes.php";
						break;
					case ("alumno"):
						include "componentes/productos.php";
						break;
					case ("tutor"):
						include "componentes/productos.php";
						include "componentes/recursos.php";
						break;
					case ("sinodal"):
						break;
					case ("moderador"):
						include "mensajesPendientes.php";
						break;
					case("demostrador"):
						break;
				}
				?>				

			</div>

			<div id="content">
				<div>

					<h3> Tema: <?php echo $nombreDelTema ?></h3>
					<h3> <?php echo ucfirst($_GET['tipoDeUsuario']) . ": " . $_SESSION['nombre'] . "," . $otros; ?></h3>
					<h3>Etapa: <span id="etapa"></span></h3>
					<div id="chat">
						<div id="sonido"></div>
						<div id="ventanaDeConversacion"></div>
						<div id="controles">
							<input type="button" value="Enviar Archivo" id="enviarArchivo"/>
							<div style="clear:both"></div>
							<textarea id="mensaje" rows="5" maxlength="255"></textarea>
							<div style="clear:both"></div>
							<label id="caracteresRestantes" >255</label>
							<button id="enviarMensaje">Enviar</button>

							<img class="boton" 
								 src="../../lib/img/sonidoOn.png" 
								 alt="Sonido: On"
								 title="Enciende o Apaga el sonido"
								 id="sonidoOnOff"
								 value="on"/>

							<?php
							if ($_GET['tipoDeUsuario'] == 'tutor') {
								include 'lib/php/botonesDeTutor.php';
							}
							?>

						</div>
					</div>

					<div id="m"></div>

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