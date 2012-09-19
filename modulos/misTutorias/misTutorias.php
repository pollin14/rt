<?php
header('Content-type:text/html; charset:utf-8');
include "../../configuracion.php";
session_start();
administraSesion();

?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="StyleSheet" href="lib/css/estilos.css" type="text/css"/>
		<link rel="StyleSheet" href="../loged/loged.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="../../lib/css/esviap.css"/>
        <script type="text/javascript" src="../../lib/js/jquery.js"></script>
        <script type="text/javascript" src="../../lib/js/funciones.js"></script>
        <script type="text/javascript" src="misTutorias.js"></script>
    </head>
    <body>
	   <?php include "../../lib/php/encabezado.php"?>
	   <?php include "../../lib/php/menu.php"?>
	   <div id="menu">
		  <ul>
			 <li title="buscaTutorias">Mis Tutorías</li>
			 <li title="buscaTutorados">¿Donde soy Tutorado?</li>
			 <li title="buscaDondeSoyObservador">¿Donde soy Observador? </li>
		  </ul>
	   </div>
	   <div id="contenido"></div>
	   <div style="clear:both"></div>
	   <?php include "../../lib/php/pieDePagina.php" ?>
    </body>
</html>
