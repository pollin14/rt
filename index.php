<?php header('Content-Type: text/html; charset=UTF-8'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Espacio Virtual de Aprendizaje</title>
<link rel="stylesheet" type="text/css" href="lib/css/esviap.css" />
<script type="text/javascript" src="lib/js/jquery.js"></script>
<script type="text/javascript" src="lib/js/funciones.js"></script>
<script type="text/javascript" src="lib/js/login.js"></script>


</head>

<body>
<p align="center"><img src="lib/img/eimle.png"alt="logo ESVIAP" /></p>

<table height="429" align="center" width="600px">
  <tr>
    <td height="401" align="center" valign="top">

    <p></p>
    <p class="azul1_0">TURed es una Plataforma de apoyo a las tutorías a distancia, ofreciendo herramientas de comunicación a tutores e interesados en adquirir conocimientos por medio de tutorías</p>
    <p></p>
<form id="form1">
    <table width="352" border="0" cellspacing="0" align="center" class="shadow">
      <tr>
        <td colspan="2" align="center"><p><strong>Ingreso a la plataforma</strong></p>
          <br />
        </td>
      </tr>
      <tr>
        <td width="116">Usuario</td>
        <td width="280">
          <label for="User"></label>
          <input type="text" name="User" id="usuario" />
    </td>
      </tr>
      <tr>
        <td>Contraseña</td>
        <td><input type="password" name="password" id="contraseña" /></td>
      </tr>
      <tr>
        <td height="55"></td>
        <td><input type="button" name="ingreso" id="ingreso" value="ingresar" /></td>
      </tr>
      <tr>
        <td colspan="2" align="right"><a href="modulos/registro/index.php" title="Alta en ESVIAP">No estoy registrado</a></td>
      </tr>
	  <tr>
		  <td colspan="2" align="right"><a href="modulos/recuperacionDeContrasena/recuperacionDeContrasena.php" title="Recuperar Correo">Recuperar Contraseña</a></td>
	  </tr>
    </table>
</form>
<p></p>
    <p><strong><a href="Privacidad.php">Política  de privacidad y manejo de datos personales</a><a href="modulos/estadisticas/index.php">.</a></strong></p>
  <tr><td valign="top" height="20">
<?php include "lib/php/pieDePagina.php" ?>
</td></tr></table>
<p>&nbsp;</p>
</body>
</html>
