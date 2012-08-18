<?php 
session_start();
header('Content-Type: text/html; charset=UTF-8');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link rel="stylesheet" type="text/css" href="../../lib/css/esviap.css"/>
<link rel="stylesheet" type="text/css" href="loged.css"/>

<script type="text/javascript" src="../../lib/js/jquery.js"></script>
<script type="text/javascript" src="../../lib/js/funciones.js"></script>
<script type="text/javascript" src="loged.js"></script>
<script type="text/javascript" src="../../notificaciones/lib/js/notificaciones.js"></script>

</head>

<body>
    
    <?php include "../../lib/php/encabezado.php" ?>

	<div id="cuerpo">
		<div id="misDatos">
		    <img src="../../avatares/default.png"/>
<!--			<img src="../../avatares/<?php $_SESSION['idUsuario'] ?> .png"/>-->
<!--			<div> Subir imagen </div>-->
			<p><?php echo $_SESSION['nick']; ?></p>
			</div>
		<div id="menu">
			<ul>
				<li value="bandejaDeEntrada"><img src="../../lib/img/correo.png"/> Bandeja de entrada </li>
				<li value="misTutorias"><img src="../../lib/img/chat.png"/> Mis Tutorías </li>
				<li value="solicitudDeTutoria"><img src="../../lib/img/buscar.png"/> Solicitud de Tutoría</li>
				<li value="index.php?uid=<?php echo $_SESSION['idUsuario']; ?>"> <img src="../../lib/img/temasDeCatalogo.png"/>Mis temas de catalogo </li>
			</ul>
		</div>
		<div id="descripcion"></div>
		<div id="contenido">
		</div>
	</div>
	<div class="limpiador"></div>
	
	<?php include "../../lib/php/pieDePagina.php" ?>
	
</body>
</html>