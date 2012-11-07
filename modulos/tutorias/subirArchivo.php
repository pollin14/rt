<!DOCTYPE html>
<html>
  <head>
    <title></title>

  </head>
  <body>

<?php 

/**
 * Este script guarda los archivos subidos en el servidor donde se 
 * esta ejecutando y regresa una url a travez de javascript para ser
 * pasado a la ventana que abrio esta ventana de carga de archivos.
 */

session_start();
header('Content-Type: text/html; charset=UTF-8');

include "../../configuracion.php";
include "../../lib/php/utils.php";
include "../../lib/php/queries.php";
include "lib/php/funciones.php";

$idTutoria  = $_POST['idTutoria'];
$tipoDeUsuario = $_POST['tipoDeUsuario'];
$idEtapa = $_POST['idEtapa'];
$url        = "";
$idTema     = "";
$hint       = $_POST['hint'];
$descripcion = $_POST['descripcion'];
$idUsuario = $_POST['idUsuario'];


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
        $url = 'http://' .$_SERVER['SERVER_ADDR'] . '/rt/archivosSubidos/chat/'. $idTutoria . "/" .$idUsuario . "/" . $nombreReal;
        
        if(!file_exists($directorio)){
            mkdir($directorio,0777,true);
        }
        
        if (move_uploaded_file($nombreTemporal, $directorio . $nombreReal)){
			$mensaje = "Por favor revisa el siguiente archivo: ";
			$mensaje .= '<a href=\"' . $url . '\" title=\"' . $nombreReal . '\">' . $nombreReal . '</a>';
			saveMensaje($idTutoria, $idUsuario, $idEtapa, $tipoDeUsuario, $mensaje, $db);
        }else{
            echo "<p>Ups! Ocurrió un problema y no se pudo subir el archivo.</p>";
			echo "<p>Puede que se demasiado grande. Verifica";
			echo " que pese no más de 4MB.</p>";
			exit();
        }
        echo '<p>Archivo subido con exito. Cerrando...</p> <div class="loading"></div>';
		echo '<script type="text/javascript">
				window.setTimeout(window.close, 3000);</script>';
        break;
    case ("recursos"):
        if($esArchivo){
            
            $directorio = "../../archivosSubidos/recursos/". $idTema . "/";
            $url = 'http://' .$_SERVER['SERVER_ADDR'] . '/rt/archivosSubidos/recursos/' . $idTema ."/" . $nombreReal;
            
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
                echo "<p>Ups! Ocurrió un problema y no se pudo subir el recurso.</p>";
				echo "<p>Puede que tu dirección web este mal.</p>";
                exit();
            }
        }
        echo "Archivo subido con exito. Cerrando...";
		echo '<script type="text/javascript">
				window.setTimeout(window.close, 3000);
				</script>';
        break;
    case ("productos"):       
		
		$nombreDelProducto = dameNombreDelProducto($_POST['idBoton'],$db);
		$extension = dameExtension($nombreReal);
        $directorio = "../../archivosSubidos/productos/". $idTutoria . "/";
        $url = 'http://' .$_SERVER['SERVER_ADDR'];
		$url.= '/rt/archivosSubidos/productos/'. $idTutoria . "/";
		$url .= $nombreDelProducto . $extension;
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
        
        if (move_uploaded_file($nombreTemporal, $directorio .$nombreDelProducto . $extension)){

        }else{
            echo "<p>Ups! Ocurrió un problema.</p>";
            echo "<p>Posiblemente, ya subiste este producto.";
			echo " Para actualizarlo, borralo y despues subelo.</p>";
            exit();
        }
        echo "Archivo subido con exito. Cerrando...";
		echo '<script type="text/javascript">
				window.setTimeout(window.close, 3000);
				</script>';
        break;       
}
?>
      
  </body>
</html>