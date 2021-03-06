<?php 
session_start();
header('Content-Type: text/html; charset=UTF-8');
include "../../configuracion.php";
administraSesion();
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
<link rel="stylesheet" type="text/css" href="../../lib/css/esviap.css"/>
<link rel="stylesheet" type="text/css" href="loged.css"/>

<script type="text/javascript" src="../../lib/js/jquery.js"></script>
<script type="text/javascript" src="../../lib/js/funciones.js"></script>
<script type="text/javascript" src="loged.js"></script>
<script type="text/javascript" src="../../modulos/notificaciones/lib/js/notificaciones.js"></script>
<script type="text/javascript">
<?php echo 'var REMOTE_SERVER="' . REMOTE_SERVER . '";'; ?>
<?php echo "var idUsuario=\"" .$_SESSION['idUsuario']  . "\";"; ?>
</script>

</head>

<body>
    
    <?php include "../../lib/php/encabezado.php" ?>

	<div id="cuerpo">
		
		<div id="misDatos">
            <?php 
            $imagen = $_SESSION['idUsuario'] . ".jpg";
            
//            if( !file_exists("../../avatares/".$imagen)){
//                $imagen = "default.jpg";
//            }
            echo '<img src="'. REMOTE_SERVER . 'avatares/' .$imagen .'"';
            echo 'title="Click para subir un nuevo avatar." ';
			echo "style=\"background-image:url('" . REMOTE_SERVER . "avatares/default.jpg');\"/>";
            ?>
			<p><?php echo $_SESSION['nombre']; ?></p>
			<p><a href="cerrarSesion.php">Cerrar Sesión</a> </p>
		</div>
		
		<div id="menu">
			<ul>
				<li value="bandejaDeEntrada"><a href="../mensajesPrivados/bandejaDeEntrada.php"><img src="../../lib/img/correo.png" id="imagen_correo"/> Bandeja de entrada</a> </li>
				<li value="misTutorias"><a href="../misTutorias/misTutorias.php"><img src="../../lib/img/chat.png"/> Mis Tutorías </a></li>
				<li value="solicitudDeTutoria"><a href="../solicitudDeTutoria/solicitudDeTutoria.php"><img src="../../lib/img/buscar.png"/> Solicitud de Tutoría</a></li>
				<li value="misTemasDeCatalogo"><a href="../alta_en_arbol/index.php?uid=<?php echo $_SESSION['idUsuario']; ?>" ><img src="../../lib/img/temasDeCatalogo.png"/>Mis temas de catálogo</a> </li>
			</ul>
		</div>
		<div id="descripcion"></div>
	</div>
	<div class="limpiador"></div>
	
	<?php include "../../lib/php/pieDePagina.php" ?>
	
</body>
</html>
