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
      <script type="text/javascript" src="../../lib/js/jquery.js"></script>
<?php

include "../../configuracion.php";
include "../../lib/php/utils.php";
include "../../lib/php/queries.php";

administraSesion();

$idTutoria  = $_POST['idTutoria'];
$url        = "";
$idTema     = "";
$hint       = $_POST['hint'];
$descripcion = $_POST['descripcion'];
$idUsuario = $_SESSION['idUsuario'];


$tipo       = $_POST['tipo'];
$crp        = $_POST['crp']; // = recursos|chat|productos

if ( $tipo == "archivo"){
	if($_FILES['archivo']['name'] == ""){
		echo "Nombre del archivo invalido";
		exit();
	}else{
		$nombreReal = utf8_encode($_FILES['archivo']['name']);
		$nombreTemporal = $_FILES['archivo']['tmp_name'];
	}
}

if( $tipo == "url" && $_POST['url'] != ""){
    $nombreReal = $_POST['url'];
}

$esArchivo = ($tipo == "url" )?false:true; 

$db = dameConexion();

//Conseguimos el idTema de la tutoria.
$query = sprintf("select idTema from Tutorias where idTutoria = %d;", $idTutoria);

$result = $db -> query($query);
if($result && $row = $result -> fetch_assoc()){
    $idTema = $row['idTema'];
}


$query = "";

switch($crp){
    case ("chat"):
        $directorio = "../../archivosSubidos/chat/". $idTutoria . "/" . $idUsuario . "/";		
        $url = $directorio . $nombreReal;
        
        if(!file_exists($directorio)){
            mkdir($directorio,0777,true);
        }
        
        if (move_uploaded_file($nombreTemporal, $directorio . $nombreReal)){
            echo '<span id="info"';
            echo ' value="' .$url .'">';
            echo '</span>';
        }else{
            echo "<p>Ups! Ocurrió un problema y no se pudo subir el archivo.</p>";
				echo "<p>Puede que se demasiado grande. Verifica";
				echo " que pese no más de 4MB.</p>";
                exit();
        }
        echo "Archivo subido con exito. Cerrando...";
		echo '<script type="text/javascript">
				$(document).ready(function(){
				window.setTimeout(window.close, 3000);
				window.opener.window.urlDelArchivo = $("#info").attr("value");
				});</script>';
        break;
    case ("recursos"):
        if($esArchivo){
            
            $directorio = "../../archivosSubidos/recursos/". $idTema . "/";
            $url = $directorio . $nombreReal;
            
            $query = sprintf('insert into Recursos values(%d,"%s","%s","%s")', 
                    $idTema, $url,$descripcion ,$hint);
            
            if (!$db -> query($query)){
                echo "<p>Ups! Ocurrió un problema y no se pudo subir el recurso.</p>";
				echo "<p>Puede que se demasiado grande. Verifica";
				echo " que pese no más de 4MB.</p>";
                exit();
                
            }
            
            if(!file_exists($directorio)){
                mkdir($directorio,0777,true);
            }
            
            if (move_uploaded_file($nombreTemporal, $directorio . $nombreReal)){
                echo '<span id="info"';
                echo ' value="' . $url . '">';
                echo '</span>';
            }else{
                echo "<p>Ups! Ocurrió un problema y no se pudo subir el recurso.</p>";
				echo "<p>Puede que se demasiado grande. Verifica";
				echo " que pese no más de 4MB.</p>";
                exit();
            }
        }else{
            
            $url = (strpos($nombreReal,"http://") !== FALSE)? $nombreReal: "http://" . $nombreReal;
            
            $query = sprintf('insert into Recursos values(%d,"%s","%s","%s")', 
                    $idTema, $url,$descripcion ,$hint);
            
            if (!$db -> query($query)){
                echo "<p>Error en al insertar.</p>";
                exit();
            }
            
            echo '<span id="info"';
            echo ' value="' . $url . '"';
            echo '</span>';
        }
        echo "Archivo subido con exito. Cerrando...";
		echo '<script type="text/javascript">
				$(document).ready(function(){
				window.setTimeout(window.close, 3000);
				window.opener.window.urlDelArchivo = $("#info").attr("value");
				});</script>';
        break;
    case ("productos"):       
		
		$nombreDelProducto = dameNombreDelProducto($_POST['idBoton'],$db);
		$extension = dameExtension($nombreReal);
        $directorio = "../../archivosSubidos/productos/". $idTutoria . "/";
        $url = $directorio . $nombreDelProducto . $extension;
        $query = sprintf('insert into Productos values(%d,"%s","%s","%s")', 
                    $idTutoria, $url , $descripcion ,$hint );
		
        
        if (!$db -> query($query)){
			echo "<p>Ups! Ocurrió un problema.</p>";
            echo "<p>Posiblemente, ya subiste este producto.";
			echo " Para actualizarlo, borralo y despues subelo.</p>";
            exit();
        }
        
        if(!file_exists($directorio)){
            mkdir($directorio,0777,true);
        }
        
        if (move_uploaded_file($nombreTemporal, $url)){
            echo '<span id="info"';
            echo ' value="' . $url . '"';
            echo '</span>';
        }else{
            echo "<p>Error al mover el archivo.</p>";
            echo "de " . $nombreTemporal . " a " . $url;
            exit();
        }
        echo "Archivo subido con exito. Cerrando...";
		echo '<script type="text/javascript">
				$(document).ready(function(){
				window.setTimeout(window.close, 3000);
				window.opener.window.urlDelArchivo = $("#info").attr("value");
				});</script>';
        break;       
}
?>
      
  </body>
</html>