<?php
/**
 * Este script guarda los archivos subidos en el servidor donde se 
 * esta ejecutando y regresa una url a travez de javascript para ser
 * pasado a la ventana que abrio esta ventana de carga de archivos.
 */
include "../../configuracion.php";

if (isset($_POST['idTutoria'])) {

	session_start();
	header('Content-Type: text/html; charset=UTF-8');

	include "../../lib/php/utils.php";
	include "../../lib/php/queries.php";
	include "lib/php/funciones.php";

	$idTutoria = $_POST['idTutoria'];
	$tipoDeUsuario = $_POST['tipoDeUsuario'];
	$idEtapa = $_POST['idEtapa'];
	$url = "";
	$hint = $_POST['hint'];
	$descripcion = $_POST['descripcion'];
	$idUsuario = $_POST['idUsuario'];


	$tipo = $_POST['tipo'];
	$crp = $_POST['crp']; // = recursos|chat|productos

	if ($tipo == "archivo") {
		if ($_FILES['archivo']['name'] == "") {
			echo "Nombre del archivo invalido";
			exit();
		} else {
			$nombreReal = utf8_encode($_FILES['archivo']['name']);
			$nombreTemporal = $_FILES['archivo']['tmp_name'];
		}
	}

	if ($tipo == "url" && $_POST['url'] != "") {
		$nombreReal = $_POST['url'];
	}

	$esArchivo = ($tipo == "url" ) ? false : true;

	$db = dameConexion();

	//Conseguimos el idTema de la tutoria.
	$idTema = dameIdTemaDeLaTutoria($idTutoria, $db);

	$exito = ''; //menaje de exito;
	$error = ''; // mensaje de error;
	$query = "";

	switch ($crp) {
		case ("chat"):
			$directorio = "../../archivosSubidos/chat/" . $idTutoria . "/" . $idUsuario . "/";
			$url = 'http://' . $_SERVER['SERVER_ADDR'] . '/rt/archivosSubidos/chat/' . $idTutoria . "/" . $idUsuario . "/" . $nombreReal;

			if (!file_exists($directorio)) {
				mkdir($directorio, 0777, true);
			}

			if (move_uploaded_file($nombreTemporal, $directorio . $nombreReal)) {
				$mensaje = "Por favor revisa el siguiente archivo: ";
				$mensaje .= '<a href=\"' . $url . '\" title=\"' . $nombreReal . '\">' . $nombreReal . '</a>';
				saveMensaje($idTutoria, $idUsuario, $idEtapa, $tipoDeUsuario, $mensaje, $db);
				$exito .= '<p>Archivo subido con exito. Cerrando...</p> <div class="loading"></div>';
				;
			} else {
				$error .= "<p>Ups! Ocurrió un problema y no se pudo subir el archivo.</p>";
				$error .= "<p>Puede que se demasiado grande. Verifica";
				$error .= " que pese no más de 4MB.</p>";
			}
			break;
		case ("recursos"):
			if ($esArchivo) {

				$directorio = "../../archivosSubidos/recursos/" . $idTema . "/";
				$url = 'http://' . $_SERVER['SERVER_ADDR'] . '/rt/archivosSubidos/recursos/' . $idTema . "/" . $nombreReal;

				$query = sprintf('insert into Recursos values(%d,"%s","%s","%s")', $idTema, $url, $descripcion, $hint);

				if (!$db->query($query)) {
					$error .= "<p>Ups! Ocurrió un problema y no se pudo subir el recurso.</p>";
					$error .= "<p>Puede que se demasiado grande. Verifica";
					$error .= " que pese no más de 4MB.</p>";
				} else {
					if (!file_exists($directorio)) {
						mkdir($directorio, 0777, true);
					}

					if (move_uploaded_file($nombreTemporal, $directorio . $nombreReal)) {
						$exito .= "<p>Archivo subido con exito. Cerrando...</p>";
						;
					} else {
						$error .= "<p>Ups! Ocurrió un problema y no se pudo subir el recurso.</p>";
						$error .= "<p>Puede que se demasiado grande. Verifica";
						$error .=" que pese no más de 4MB.</p>";
					}
				}
			} else {

				$url = (strpos($nombreReal, "http://") !== FALSE) ? $nombreReal : "http://" . $nombreReal;

				$query = sprintf('insert into Recursos values(%d,"%s","%s","%s")', $idTema, $url, $descripcion, $hint);

				if (!$db->query($query)) {
					$error .= "<p>Ups! Ocurrió un problema y no se pudo subir el recurso.</p>";
					$error .= "<p>Puede que tu dirección web este mal.</p>";
				} else {
					$exito .= "Archivo subido con exito. Cerrando...";
					;
				}
			}
			break;
		case ("productos"):

			$nombreDelProducto = dameNombreDelProducto($_POST['idBoton'], $db);
			$extension = dameExtension($nombreReal);
			$directorio = "../../archivosSubidos/productos/" . $idTutoria . "/";
			$url = 'http://' . $_SERVER['SERVER_ADDR'];
			$url.= '/rt/archivosSubidos/productos/' . $idTutoria . "/";
			$url .= $nombreDelProducto . $extension;
			$query = sprintf('insert into Productos values(%d,"%s","%s","%s")', $idTutoria, $url, $descripcion, $hint);


			if (!$db->query($query)) {
				$exito .= "<p>Ups! Ocurrió un problema.</p>";
				$exito .= "<p>Posiblemente, ya subiste este producto.";
				$exito .= " Para actualizarlo, borralo y despues subelo.</p>";
			} else {

				if (!file_exists($directorio)) {
					mkdir($directorio, 0777, true);
				}

				if (move_uploaded_file($nombreTemporal, $directorio . $nombreDelProducto . $extension)) {
					$exito .= "<p>Archivo subido con exito. Cerrando...</p>";
				} else {
					$error.= "<p>Ups! Ocurrió un problema.</p>";
					$error.= "<p>Posiblemente, ya subiste este producto.";
					$error.= " Para actualizarlo, borralo y despues subelo.</p>";
				}
			}
	}
}
?>

<?php if (isset($_POST['idTutoria'])): ?>
	<!DOCTYPE html>
	<html>
		<head>
			<title>Estado de la subida de Archivos</title>
			<script type="text/javascript">
				window.setTimeout(window.close, 5000);
				var x = 5;
				var un_segundo = 1000;
				
				window.setInterval(
					function(){
						x--;
						document.getElementById('timer').textContent = x;
					},un_segundo)
			</script>
		</head>
		<body>
			<div class="error"><?php echo $error ?></div>
			<div class="exito"><?php echo $exito ?></div> 
			<p>Cerrando en ... <span id="timer">5</span></p>
		</body>
	</html>

<?php else: ?>
	<!DOCTYPE html>
	<html>
		<head>
			<title></title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="text/javascript" src="../../lib/js/funciones.js"></script>
			<script type="text/javascript" src="../../lib/js/jquery.js"></script>
			<script type="text/javascript">
				//Agregamos un campo oculto para pasar la direccion donde se
				//guardara el archivo. Ejemplo de direccion: recursos/1/2/ o chat/2/4/
		        
				var tipo = "archivo";
		        
				$(document).ready(function(){
					
					var crp =getUrlVars()['crp']
					var tmp;
		            
					/* Datos ocultos a traves de inputs*/
		            
					$('#idTutoria').val(getUrlVars()['idTutoria']);
					$('#crp').val(crp);
					$('#idEtapa').val(getUrlVars()['idEtapa']);
					$('#tipoDeUsuario').val(getUrlVars()['tipoDeUsuario'])
					$('#idUsuario').val(getUrlVars()['idUsuario'])
					
					//Si se subio un producto,debemos detectar el id del boton
					if ( crp == "productos"){
						tmp = '<input type="hidden" name="idBoton" value="' + 
							getUrlVars()['idBoton']+'"/>';
						$("form").html( $('form').html() + tmp);
					}
		            
		            
					// Por defecto ocultamos la subida de url 
					// y mostramos la subida de archivo.
		            
					switch(crp){
						case ('recursos'):
							$('#divSubirUrl').hide();
							$('#divSubirArchivo').show();

							//eventos del tipo de archivo.
							$('input:radio[name=tipo]').click(function(){
								var tipo = $(this).attr('value');
								if(tipo == "url"){
									$('#divSubirUrl').show();
									$('#divSubirArchivo').hide();
								}else{
									$('#divSubirArchivo').show();
									$('#divSubirUrl').hide();
								}
							});
							break;
						case('chat'):
							$('#descripcion').hide();
							$('#hint').hide();
						default://El chat y los productos no puden ser urls
							$('#divSubirUrl').hide();
							$('#url').hide();
							break;
					}
					
					//			$('#divSubirArchivo input[type="file"]').change(function(){
					//				if($(this).val().indexOf(" ") != -1){
					//					alert("El nombre del archivo tiene espacios en blanco.");
					//					$(this).val("");
					//				}
					//			});
				});
			</script>
		</head>
		<body>
			<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data"> 
				<input type="hidden" id="idTutoria" name="idTutoria"/>
				<input type="hidden" id="crp" name="crp"/>
				<input type="hidden" id="idEtapa" name="idEtapa"/>
				<input type="hidden" id="tipoDeUsuario" name="tipoDeUsuario"/>
				<input type="hidden" id="idUsuario" name="idUsuario"/>
				<table>
					<tr>
						<td>Tipo: </td>
						<td>
							<label>Archivo</label><input type="radio" name="tipo" value="archivo" checked/>
						</td>
						<td id="url">
							<label>URL</label><input type="radio" name="tipo" value="url"/>
						</td>
					</tr>

					<tr id="descripcion">
						<td>Descripcion</td>
						<td><input type="text" name="descripcion"/></td>
					</tr>

					<tr id="hint">
						<td>Hint</td><td><input type="text" name="hint"/></td>
					</tr>
				</table>
				<div id="divSubirUrl">
					<label>URL</label><input type="text" name="url"/>
					<input type="submit" value="Guardar"/>
				</div>
				<div id="divSubirArchivo">
					<input type="file" name="archivo"/>
					<input type="submit" value="Guardar"/>
				</div>
			</form>
		</body>
	</html>
<?php endif; ?>