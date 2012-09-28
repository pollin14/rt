<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

function asigna($dato) {
	if (isset($_POST[$dato])) {
		$_SESSION[$dato] = $_POST[$dato];
	} else {
		$_SESSION[$dato] = "";
	}
}

asigna('email');
asigna('telefono');
//var_dump($_SESSION);
?>
<?php
$insertSQL = "";
if (!function_exists("GetSQLValueString")) {

	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}

		$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

		switch ($theType) {
			case "text":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : ".";
				break;
			case "long":
			case "int":
				$theValue = ($theValue != "") ? intval($theValue) : ".";
				break;
			case "double":
				$theValue = ($theValue != "") ? doubleval($theValue) : ".";
				break;
			case "date":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : ".";
				break;
			case "defined":
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
		return $theValue;
	}

}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	$insertSQL = sprintf("INSERT INTO users (IdUser, Nombre, Apellidos, Sexo, Id_Entidad, Nodo, email, telefono, password, CCT, Turno, Cargo_SEP) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", GetSQLValueString($_POST['IdUser'], "text"), GetSQLValueString($_POST['Nombre'], "text"), GetSQLValueString($_POST['Apellidos'], "text"), GetSQLValueString($_POST['Sexo'], "text"), GetSQLValueString($_POST['IdEntidad'], "int"), GetSQLValueString($_POST['Nodo'], "text"), GetSQLValueString($_POST['email'], "text"), GetSQLValueString($_POST['telefono'], "text"), GetSQLValueString($_POST['password'], "text"), GetSQLValueString($_POST['CCT'], "text"), GetSQLValueString($_POST['Turno'], "text"), GetSQLValueString($_POST['Cargo_SEP'], "text"));

	echo $insertSQL;
	mysql_select_db($database_esviap_conn, $esviap_conn);
	$Result1 = mysql_query($insertSQL, $esviap_conn) or die(mysql_error());

	$insertGoTo = "index.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_esviap_conn, $esviap_conn);
$query_Recordset1 = "SELECT * FROM Entidades";
$Recordset1 = mysql_query($query_Recordset1, $esviap_conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_esviap_conn, $esviap_conn);
$query_rs_nodos = "SELECT * FROM Nodos";
$rs_nodos = mysql_query($query_rs_nodos, $esviap_conn) or die(mysql_error());
$row_rs_nodos = mysql_fetch_assoc($rs_nodos);
$totalRows_rs_nodos = mysql_num_rows($rs_nodos);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Alta de Usuarios</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<link rel="StyleSheet" href="../../lib/css/style.css" type="text/css"/>
			<script type="text/javascript" src="../../lib/js/jquery.js"></script>
			<script type="text/javascript">

				function multiNivel(){
					document.getElementById('nivel').setAttribute('multiple', 'multiple');
					document.getElementById('nivel').setAttribute('size', '4');
					var m = 'Manten Precionado <b>Ctrl</b> en Windows o linux y <b>Command</b> si estas usando Mac ';
					m += 'para seleccionar mas de un nivel.';
					document.getElementById('nivelMensaje').innerHTML = m;
				}

				function simpleNivel(){
					document.getElementById('nivel').removeAttribute('multiple');
					document.getElementById('nivel').setAttribute('size', '1');
					document.getElementById('nivelMensaje').innerHTML="";
				}

				function toggleNivel(event){
					var nivel = document.getElementById('nodo').value;
					if( nivel == "1"){
						multiNivel();
					}else{
						simpleNivel();
					}
				}
			</script>

	</head>

	<body>

		<div id="wrapper">

			<div id="header">

			</div>

			<div id="content">			
				<form action="ingreso4.php" method="POST" name="form" id="form">
					<p>Ingresa tus datos sobre el lugar  donde vives:</p>
					<table align="center" >

						<tr valign="baseline">
							<td nowrap="nowrap" align="right">Entidad:</td>
							<td><label for="IdEntidad"></label>
								<select name="idEntidad" id="IdEntidad">

									<?php
									do {
										?>
										<option value="<?php echo $row_Recordset1['idEntidad'] ?>">
											<?php echo (trim($row_Recordset1['nombre'], ' ')); ?></option>
										<?php
									} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
									$rows = mysql_num_rows($Recordset1);
									if ($rows > 0) {
										mysql_data_seek($Recordset1, 0);
										$row_Recordset1 = mysql_fetch_assoc($Recordset1);
									}
									?>
								</select></td>
						</tr>

						<tr valign="baseline">
							<td nowrap="nowrap" align="right">Nodo:</td>
							<td><select name="idNodo" id="nodo" onchange="toggleNivel()">
									<?php
									do {
										?>
										<option value="<?php echo $row_rs_nodos['idNodo'] ?>"><?php echo $row_rs_nodos['nombre'] ?></option>
										<?php
									} while ($row_rs_nodos = mysql_fetch_assoc($rs_nodos));
									$rows = mysql_num_rows($rs_nodos);
									if ($rows > 0) {
										mysql_data_seek($rs_nodos, 0);
										$row_rs_nodos = mysql_fetch_assoc($rs_nodos);
									}
									?>
								</select>
							</td>
						</tr>
						<div id="escolar" style="display:block">
							<tr valign="baseline">
								<td nowrap="nowrap" align="right">Nivel:</td>
								<td>
									<!-- los corchetes en el nombre son para que php
											detecte el multi select -->
									<select name="idNivel[]" id="nivel">
										<option value="1">Preescolar</option>
										<option value="2">Primaria</option>
										<option value="3">Secundaria</option>
										<option value="4">Educaci&oacute;n especial</option>
									</select>
									<div id="nivelMensaje"></div>
								</td>
							</tr>
							<tr valign="baseline">
								<td nowrap="nowrap" align="right">Modalidad:</td>
								<td>
									<select name="idModalidad" id="modalidad">
										<option value='0'>no aplica</option>
										<option value='1'>Preescolar Inicial</option>
										<option value='2'>Preescolar General</option>
										<option value='3'>Preescolar Comunitario</option>
										<option value='4'>Preescolar Indígena</option>
										<option value='5'>Primaria General</option>
										<option value='6'>Primaria Comunitaria</option>
										<option value='7'>Primaria Indígena</option>
										<option value='8'>Secundaria General</option>
										<option value='9'>Secundaria Técnica</option>
										<option value='10'>Secundaria Comunitaria</option>
										<option value='11'>Secundaria Para Trabajadores</option>
										<option value='12'>Telesecundaria</option>
										<option value='13'>Educación Especial CAM</option>
										<option value='14'>Educación Especial USAER</option>
									</select>
								</td>
							</tr>
						</div>
						<tr valign="baseline">
							<td nowrap="nowrap" align="right">&nbsp;</td>
							<td><input type="submit" value="Continuar" /></td>
						</tr>
					</table>
				</form>
			</div>

			<div id="footer">
				<div id="footer-valid">
					<?php include '../../lib/php/direccion.php' ?>
				</div>
			</div>

		</div>

	</body>
</html>
