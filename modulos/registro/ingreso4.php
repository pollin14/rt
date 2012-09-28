<?php
session_start();
include '../../configuracion.php';
header('Content-Type: text/html; charset=UTF-8');

function asigna($dato) {
	if (isset($_POST[$dato])) {
		$_SESSION[$dato] = $_POST[$dato];
	} else {
		$_SESSION[$dato] = "null";
	}
}

asigna('idEntidad');
asigna('idNodo');
asigna('idNivel');
asigna('idModalidad');
//var_dump($_SESSION);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Alta de Usuarios</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<link rel="StyleSheet" href="../../lib/css/style.css" type="text/css"/>
			<script type="text/javascript" src="../../lib/js/jquery.js"></script>
			<script type="text/javascript" src="lib/js/jquery.js"></script>
			<script type="text/javascript" src="lib/js/cct.js"></script>
			<link rel="stylesheet" type="text/css" href="lib/css/cct.css" />

	</head>

	<body>

		<div id="wrapper">

			<div id="header">

			</div>

			<div id="content">			
				<form action="ingreso5.php" method="POST" name="form" id="form">
                    <p>Ingresa tus datos  laborales (Clave de Centro de Trabajo y el turno):</p>
                    <table>
                        <tr>
                            <td colspan="2"><h4>Ingresa tus datos</h4></td>
                        </tr>
                        <tr >
                            <td>CCT:</td>
                            <td><input name="cct" type="text" id="cct" value="" size="10" maxlength="10" /></td>
                        </tr>
                        <tr>
                            <td>Turno:</td>
                            <td>
                                <select name="idTurno" id="turno">
                                    <option value='1'>Matutino</option>
                                    <option value='2'>Vespertino</option>
                                    <option value='3'>Nocturno</option>
                                    <option value='4'>Discontinuo</option>
                                    <option value='5'>Mixto</option>              
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="submit" value="Continuar" /></td>
                        </tr>
                    </table>
                </form>
                <input type="hidden" id="mail" value="<?php echo $_SESSION['email']; ?>"></input>
                <p id="preview"><a>No cuento con CCT</a></p>
                <div id="mascara"> 
                    Estado:<select>
						<?php
						$db = dameConexion();

						$buscaEntidades = 'SELECT * FROM entidades;';
						$resultadoDeEntidades = $db->query($buscaEntidades);
						while ($resultadoDeEntidades && $filaDeEntidades = $resultadoDeEntidades->fetch_assoc()) {
							echo '<option value="' . $filaDeEntidades['idEntidad'] . '">';
							echo $filaDeEntidades['nombre'];
							echo '</option>';
						}
						?>
                    </select>
                    <p>Entidad:
                        <input type="text" id="entidad">

                        </input></p>
                    <p>Localidad:
                        <input type="text" id="localidad">

                        </input>
                    </p>
                    <p>Municipio:
                        <input type="text" id="Municipio">

                        </input>
                    </p>
                    <p>Nombre de la escuela:
                        <input type="text" id="escuela">

                        </input>
                    </p>
                    <p id="cerrar">Ok</p>
                </div>
			</div>

			<div id="footer">
				<div id="footer-valid">
					<?php include '../../lib/php/direccion.php' ?>
				</div>
			</div>

		</div>

	</body>
</html>
