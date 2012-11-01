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

$db = dameConexion();

$idTutoria  = $_POST['idTutoria'];
$url        = "";
$idTema     = "";
$hint       = $db->real_escape_string($_POST['hint']);
$descripcion = $db->real_escape_string($_POST['descripcion']);
$idUsuario = $_SESSION['idUsuario'];


$tipo       = $_POST['tipo'];
$crp        = $_POST['crp']; // = recursos|chat|productos

if ( $tipo == "archivo"){
	if($_FILES['archivo']['name'] == ""){
		echo "Nombre del archivo invalido";
		exit();
	}else{
		$nombreReal = $_FILES['archivo']['name'];
		$nombreTemporal = $_FILES['archivo']['tmp_name'];
	}
}

if( $tipo == "url" && $_POST['url'] != ""){
    $nombreReal = $db->real_escape_string($_POST['url']);
}

$esArchivo = ($tipo == "url" )?false:true; 

if(!$db){die ("Error al conectarse a la base de datos.");}

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
            echo "<p>Ups! Ocurrió un problema al subir el archivo :(</p>";
            echo "de " . $nombreTemporal . " a " . $directorio;
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
                $s = sprintf('select descripcion,hint from Recursos where url = "%s";', $url);
				$re = $db->query($query);
				if ( !$re){
					echo "<p>Ups! Ocurrió un problema al subir el recuros :( </p>";
					echo "<p>Ya puedes cerrar la ventana.</p>";
				}else{
					$r = $re->fetch_assoc();
					echo "<p>Ya existe un archivo con el mismo nombre. Para";
					echo " actualizarlo elimina el archivo cuya descipcion es";
					echo " <b>" . $r['descripcion'] . "</b> y hint es ";
					echo " <b>" . $r['hint'] . "</b>.</p>";
					echo "<p>Ya puedes cerrar la ventana</p>";
				}
				
                exit();//salimos para no mover el archivo.
            }
            
            if(!file_exists($directorio)){
                mkdir($directorio,0777,true);
            }
            
            if (move_uploaded_file($nombreTemporal, $url)){
                echo '<span id="info"';
                echo ' value="' . $url . '">';
                echo '</span>';
            }else{
                echo "<p>Ups! Ocurrió un problema al subir el recurso.</p>";
                exit();
            }
        }else{
            
            $url = (strpos($nombreReal,"http://") !== FALSE)? $nombreReal: "http://" . $nombreReal;
            
            $query = sprintf('insert into Recursos values(%d,"%s","%s","%s")', 
                    $idTema, $url,$descripcion ,$hint);
            
            if (!$db -> query($query)){
                echo "<p>UPs! Ocurrió un problema al guardar el recuros.(url)</p>";
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
            echo "<p>Ups! Ocurrió un problema al subir el producto</p>";
            echo "<p>Posiblemente, ya subiste este producto.";
			echo " Para actualizarlo, borralo y despues vuelvelo a subir.</p>";
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
            echo "<p>Ups! Ocurrió un problema al subir el producto</p>";
            echo "<p>Posiblemente, ya subiste este producto.";
			echo " Para actualizarlo, borralo y despues vuelvelo a subir.</p>";
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