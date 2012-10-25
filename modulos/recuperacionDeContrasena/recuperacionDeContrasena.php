<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../../lib/css/esviap.css"/>
		<script type="text/javascript" src="../../lib/js/jquery.js"></script>
	</head>
	<body>
<?php 
include "../../lib/php/encabezado.php";

if(!isset($_POST['email'])){?>
		
		<div>
			<form method="post" action="recuperacionDeContrasena.php">
			<label> ¿Cual es tu correo electronico? </label>
			<input type="text" value="" name="email" id="email"/>
			<input type="submit" value="Enviar Contraseña"/>
			</form>
		</div>
		 <?php include "../../lib/php/pieDePagina.php"?>
	</body>
</html>
<?php
exit();
}

include "../../configuracion.php";

$db = dameConexion();

$query = sprintf("select nombre,nick,contraseña from Usuarios where email = '%s';", $_POST['email']);

$result = $db -> query($query);

if (! $result ){
	echo $query;
}

if ($result -> num_rows > 0){
	
	$row = $result -> fetch_assoc();
	
	$asunto = "Recuperacion de contraseña. RT";
	$mensaje = "<p>Hola <b>" . $row['nombre'] . "</b>!";
	$mensaje .= "<p>Tu usuario es: <b>" . $row['nick'] . "</b></p>";
	$mensaje .= "<p> contraseña es: <b>" . $row['contraseña'] . "</b></p>";
	$mensaje .= "<p>No lo vuelvas a olvidar.</p>";
	
	mail( $_POST['email'] , $asunto, $mensaje ,HEADERS_MAIL);
	
	echo "<p>Correo enviado. En algunos segundos recibiras un correo con tu";
	echo " usuario y contraseña.</p>";
    echo "<p>Ya puedes cerrar esta ventan.</p>";
}else{
	?>
		<div>
			<form method="post" action="recuperacionDeContrasena.php">
			<label> ¿Cual es tu correo electronico? </label>
			<input type="text" value="" name="email" id="email"/>
			<button id="enviar">Enviar contraseña</button>
			</form>
		</div>
<?php
	echo "<p>Lo siento, no hay ningun usuario con esta cuenta de correo</p>";
}

include "../../lib/php/pieDePagina.php"
?>
	</body>
</html>