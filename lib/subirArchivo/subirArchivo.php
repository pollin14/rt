<?php 

session_start();
header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<html>
  <head>
    <title></title>

  </head>
  <body>
      <script type="text/javascript" src="../../lib/js/jquery.js"> </script>
<?php

$idUsuario = $_SESSION['idUsuario'];
$extension = $_FILES['archivo']['type'];
$nombreReal = $_FILES['archivo']['name'];
$nombreTemporal = $_FILES['archivo']['tmp_name'];

$directorio = "../../avatares/";

if($extension != "image/jpeg" and
        $extension != "image/pjpeg"){
    echo "Tu imagen debe estar en formato jpg.<br/>";
    echo $extension;
    exit();
}

$extension = ".jpg";

if(!file_exists($directorio)){
    mkdir($directorio,0777,true);
}

if (move_uploaded_file($nombreTemporal, 
        $directorio . $idUsuario . $extension)){
    echo '<script type="text/javascript">';
    echo '$(document).ready(function(){';
    echo 'window.setTimeout(window.close, 2000);';
    echo 'window.opener.window.location = window.opener.window.location;';
    echo '});';
    echo '</script>';
    echo "Avatar subido con exito. Cerrando ventana.";
}else{
    echo "<p>Error al mover el archivo.</p>";
    echo "<p>Cerrar la ventana manualmente</p>";
    echo "de " . $nombreTemporal . " a "  . $nombreReal;
}
      
	   
?>
      
  </body>
</html>

