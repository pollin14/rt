<!DOCTYPE html>
<html>
    <head>
        <title>Solicitud de Tutoria</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <link type="text/css" href="lib/css/solicitudDeTutoria.css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="../../lib/css/esviap.css"/>
        <script type="text/javascript" src="../../lib/js/jquery.js"></script>
        <script type="text/javascript" src="../../lib/js/funciones.js"></script>
        <script type="text/javascript" src="lib/js/solicitudDeTutoria.js"></script>
    </head>
    <body>
	
	   <?php include "../../lib/php/encabezado.php"?>
	   
        <p id="barraDeNavegacion"></p>
        <div id="buscarPor">
            <select size="2">
                <option value="tema">Tema</option>
                <option value="tutor">Tutor</option>
            </select>
        </div>
        <div id="lista1">
            <select size="10">
            </select>
        </div>
        <div id="lista2">
            <select size="10">
            </select>
        </div>
        <div id="enviarSolicitud">
            <button type="button" value="Enviar Solicitud" >Enviar Solicitud</button>
        </div>
        <div style="clear:both"></div>
        <div id="m"></div>
	   <?php include "../../lib/php/pieDePagina.php"?>
    </body>
</html>
