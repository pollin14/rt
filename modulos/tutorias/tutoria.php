<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include "../../configuracion.php";
include "../../lib/php/queries.php";
administraSesion();

$db = dameConexion();
$nombreDelTema = dameNombreDelTemaDeLaTutoria($_GET['idTutoria'],$db);

switch($_GET['tipoDeUsuario']){
	case ("alumno"):
		$nombreDelOtro = dameNombreDelTutorDeLaTutoria($_GET['idTutoria'],$db);
		$otros = "Tutor: " . $nombreDelOtro;
		break;
	case("demostrador"):
		$nombreDelOtro = dameNombreDelTutorDeLaTutoria($_GET['idTutoria'],$db);
		$otros = "Moderador: " . $nombreDelOtro;
		break;
	case("tutor"):
		$nombreDelOtro = dameNombreDelEstudiante($_GET['idTutoria'],$db);
		$otros = "Tutorado: " .$nombreDelOtro;
		break;
	case("moderador"):
		$nombreDelOtro = dameNombreDelEstudiante($_GET['idTutoria'],$db);
		$otros = "Demostrador: " .$nombreDelOtro;
		break;
	default:
		$otros = "Observador/Sinodal";
}

$tipoDeUsuario = $_GET['tipoDeUsuario'];
$tipo_y_nombre = ucfirst($_GET['tipoDeUsuario']) . ": " .$_SESSION['nombre'] . ", " . $otros; 
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Tutorias:
    
<?php 
    echo $_GET['tipoDeUsuario'];
?>
    
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="StyleSheet" href="../../lib/css/esviap.css" type="text/css"/>
    <link rel="StyleSheet" href="lib/css/estilos.css" type="text/css"/>
    
    <script type="text/javascript" src="../../lib/js/jquery.js"></script>
    <script type="text/javascript" src="../../lib/js/funciones.js"></script>
    <script type="text/javascript" src="../../lib/js/modernizr.js"></script>
    <script type="text/javascript" src="lib/js/chat.js"></script>
<?php echo '<script type="text/javascript">var SERVER_PATH = "' . REMOTE_SERVER .'modulos/tutorias/";</script>' ?>
  </head>
  <body>
	 <?php include "../../lib/php/encabezado.php" ?>
	 <?php include "../../lib/php/menu.php"?>
    <div>
        
			<h3> Tema: <?php echo $nombreDelTema ?></h3>
			<h3> <?php echo $tipo_y_nombre ?></h3>
			<h3> Etapa: <span id="etapa"></span></h3>
		<div id="chat">
			<div id="sonido"></div>
            <div id="ventanaDeConversacion"></div>
            <div id="controles">
                <input type="button" value="Enviar Archivo" id="enviarArchivo"/>
                <div style="clear:both"></div>
                <textarea id="mensaje" rows="5" maxlength="255"></textarea>
                <div style="clear:both"></div>
                <label id="caracteresRestantes" >255</label>
                <button id="enviarMensaje">Enviar</button>
				
				<img class="boton" 
					 src="../../lib/img/sonidoOn.png" 
					 alt="Sonido: On"
					 title="Enciende o Apaga el sonido"
					 id="sonidoOnOff"
					 value="on"/>
                
                <?php 
                if($_GET['tipoDeUsuario'] == 'tutor'){ 
                    include 'componentes/botonesDeTutor.php';
                }
                ?>
            </div>
        </div>

      
      <div class="columna"><!-- Controles particulares de cada tipo de usuario -->
			<?php include  'componentes/' .$tipoDeUsuario . '.php'?>
	  </div>

    </div>
	 <div style="clear:both"></div>
	 <?php include "../../lib/php/pieDePagina.php" ?>
  </body>
</html>