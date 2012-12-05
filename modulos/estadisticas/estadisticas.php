<?php header('Content-Type: text/html; charset=UTF-8');?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../../lib/css/esviap.css"/>
		<link rel="stylesheet" type="text/css" href="lib/css/ests.css"/>
		<script type="text/javascript" src="../../lib/js/jquery.js"></script>
		<script type="text/javascript" src="../../lib/ofc/js/swfobject.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#menu a').click(function(){
					$('#chart').show();
					$('#tabla').hide();
					swfobject.embedSWF(
					"../../lib/ofc/open-flash-chart.swf", "chart",
					"500", "500", "9.0.0", "expressInstall.swf",
					{"data-file":"graficas/datos/" + $(this).attr('value') } );
				});
			})
			
			function muestra_tabla_temas(){
				muestra_tabla('temas.php');
			}
			
			function muestra_tabla_entidades(){
				muestra_tabla('entidades.php');
			}
			
			function muestra_tabla_usuarios(){
				muestra_tabla('usuarios.php')
			}
			
			function muestra_tabla_tutorias(){
				muestra_tabla('tutorias.php')
			}
			
			function muestra_tabla_resumen(){
				muestra_tabla('resumen.php');
			}
			
			function muestra_tabla(nombre){
				$('#chart').hide();
				$('#tabla').load( "tablas/" + nombre ).show();
			}	
			</script>
        <title>Estadisticas</title>
    </head>
    <body>
		<?php include "../../lib/php/encabezado.php" ?>
		<div style="text-align: center" id="menu">
			<a value="temas.php" href="#">Catálogos</a>
			<a value="tutorias.php" href="#">Tutorías</a>
			<a value="entidades.php" href="#">Entidades</a>
			<a value="usuarios.php" href="#">Usuarios</a>
			<a value="resumen.php" href="#">Resumen</a>
			<a href="linaje.php">linaje</a>
		</div>
		<br>
		<div id="estadisticas">
			<div id="chart"></div>
			<div id="tabla"></div>
		</div>
        <?php
        // put your code here
        ?>
		<?php include "../../lib/php/pieDePagina.php" ?>
    </body>
</html>
