<?php
header('Content-Type: text/html; charset=UTF-8');
include "../../configuracion.php";
include "../../lib/php/queries.php";

$db = dameConexion();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Estadisticas</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<link rel="StyleSheet" href="../../lib/css/style.css" type="text/css"/>
			<link rel="stylesheet" href="../../lib/css/jquery-ui.css" type="text/css" media="screen" />
			<script type="text/javascript" src="../../lib/js/jquery.js"></script>
			<script type="text/javascript" src="../../lib/js/jquery-ui.js"></script>
			<script type="text/javascript" src="../../lib/ofc/js/swfobject.js"></script>
			<script type="text/javascript" src="estadisticas.js"></script>
	</head>

	<body>

		<div id="wrapper">

			<div id="header">

			</div>

			<div id="menu">
				<ul>
					<li><a href="../../modulos/loged/loged.php" name="home">Pagina de Inicio</a></li>
					<li><a href="../../modulos/mensajesPrivados/bandejaDeEntrada.php" name="bandejaDeEntrada">Bandeja De Entrada</a></li>
					<li><a href="../../modulos/misTutorias/misTutorias.php" name="misTutorias">Mis Tutorias</a></li>
					<li><a href="../../modulos/solicitudDeTutoria/solicitudDeTutoria.php" name="solicitudDeTutoria">Solicitud de Tutoria</a></li>
					<li><a href="../../modulos/alta_en_arbol/index.php?uid=<?php echo $_SESSION['idUsuario']; ?>" name="misTemasDeCatalogo">Temas de Catalogo</a></li>
				</ul>
			</div>

			<div id="sidebar">
				<div id="feed">

				</div>

				<div id="misDatos">

				</div>

				<div id="sidebar-bottom"></div>			
			</div>

			<div id="content">

				<div id="tabs">
					<ul>
						<li><a href="#tabs-1">Catalogos</a></li>
						<li><a href="#tabs-2">Tutorías</a></li>
						<li><a href="#tabs-3">Entidades</a></li>
						<li><a href="#tabs-4">Usuarios</a></li>
						<li><a href="#tabs-5">Resumen</a></li>
<!--						<li><a href="#tabs-5">Linaje</a></li>-->
					</ul>
					<div id="tabs-1">
						<div id="temas"></div>
					</div>
					<div id="tabs-2">
						<div id="tutorias"></div>
					</div>
					<div id="tabs-3">
						<div id="entidades"></div>
					</div>
					<div id="tabs-4">
						<div id="usuarios"></div>
					</div>
					<div id="tabs-5">
						<div id="resumen"></div>
					</div>
<!--					<div id="tabs-5">
						<div id="wrapper">
							<div id="linaje">
								<button>Cargar linaje</button>
								<div id="temass">
									<ul id="temas" class="s">
										<li>
											Temas
										</li>
									</ul>
								</div>
								<div id="informacion" style="display : none">
								</div>

							</div>
						</div>
					</div>-->
				</div>
				<div id="tabla"></div>
			</div>

			<div id="footer">
				<div id="footer-valid">
					<?php include '../../lib/php/direccion.php' ?>
				</div>
			</div>

		</div>

	</body>
</html>