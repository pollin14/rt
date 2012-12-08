<?php
session_start();

if (isset($_FILES['archivo'])):
	header('Content-Type: text/html; charset=UTF-8');

	$idUsuario = $_SESSION['idUsuario'];
	$extension = $_FILES['archivo']['type'];
	$nombreReal = $_FILES['archivo']['name'];
	$nombreTemporal = $_FILES['archivo']['tmp_name'];

	$directorio = "../../avatares/";

	$exito = '';
	$error = '';
	$ext = '.jpg';

	if ($extension != "image/jpeg" and
			$extension != "image/pjpeg") {
		$error .= "<p>Tu imagen debe estar en formato jpg.</p>";
		$error .= "<p>La extension de tu archivo es <strong> . " . $extension . "</strong>";
	} else {

		if (!file_exists($directorio)) {
			mkdir($directorio, 0777, true);
		}

		if (move_uploaded_file($nombreTemporal, $directorio . $idUsuario . $ext)) {
			$exito .= "<p>Avatar subido con exito. Cerrando ventana.</p>";
		} else {
			$error .= "<p>Error al mover el archivo.</p>";
			$error .= "<p>Cerrar la ventana manualmente</p>";
			$error .= "de " . $nombreTemporal . " a " . $nombreReal;
		}
	}
	?>

	<!DOCTYPE html>
	<html>
		<head>
			<title></title>
			<script type="text/javascript">
				window.setTimeout(window.close, 5000);
				var x = 5;
				var un_segundo = 1000;
							
				window.setInterval(
				function(){
					x--;
					document.getElementById('timer').textContent = x;
				},un_segundo)
			</script>
		</head>
		<body>
			<div class="error"><?php echo $error ?></div>
			<div class="exito"><?php echo $exito ?></div>
			<p> Cerrando ventana en ... <span id="timer">5</span></p>
		</body>
	</html>

<?php else: ?><!-- Formulario para subir archivo -->

	<!DOCTYPE html>
	<html>
		<head>
			<title></title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="text/javascript" src="../../lib/js/funciones.js"></script>
			<script type="text/javascript" src="../../lib/js/jquery.js"></script>
			<script type="text/javascript">
			        
				$(document).ready(function(){
					var idUsuario = getUrlVars()['idUsuario'];
					$('#idUsuario').val(idUsuario);
				})
			</script>
		</head>
		<body>
			<p>La imagen debe ser jpg y no importa sus dimensiones. 
			Sin embargo, entre más pequeña sea la se cargara más rápido.</p>
			<form method="post" action="subirArchivo.php" enctype="multipart/form-data"> 
				<input type="file" name="archivo"  /> 
				<input type="submit" value="Subir" />      
			</form>
			
			<p>Tu imagen actual: </p>
			<p><img src="../../avatares/<?php echo $_SESSION['idUsuario'] ?>.jpg" style="width:200px;display:block"/></p>

		</body>
	</html>

<?php endif ?>

