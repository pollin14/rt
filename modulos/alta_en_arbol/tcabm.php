<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
session_start();
header('content-type=text/html; charset=utf-8"');
if (!isset($_SESSION['uname']) && !isset($_SESSION['idu'])) {
	echo "<h3>Usuario inv&aacute;lido</h3>";
	exit(1);
}

if (!function_exists("GetSQLValueString")) {

	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}

		$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

		switch ($theType) {
			case "text":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "long":
			case "int":
				$theValue = ($theValue != "") ? intval($theValue) : "NULL";
				break;
			case "double":
				$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
				break;
			case "date":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "defined":
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
		return $theValue;
	}

}

if ((isset($_GET['idtc'])) && ($_GET['idtc'] != "") && (isset($_GET['accion']))) {
	switch ($_GET['accion']) {
		case "del":
			$SQL = sprintf("DELETE FROM temas WHERE idTema=%s", GetSQLValueString($_GET['idtc'], "int"));
			break;
		case "add":
			//$SQL = "insert into temas values(default,".$_SESSION['idu'].",\"".$_GET['tcname']."\",\"".$_GET['kw']."\")";
			$SQL = "insert into temas (nombre,idUsuario) values(\"" . $_GET['tcname'] . "\"," . $_SESSION['idu'] . ")";
			break;
		case "edit":
			//$SQL = "update temas set nombre=\"".$_GET['tcname']."\", kw=\"".$_GET['kw']."\" where idTema=".$_GET['idtc'];
			$SQL = "update temas set nombre=\"" . $_GET['tcname'] . "\" where idTema=" . $_GET['idtc'];
			break;
	}
//echo $SQL;

	$re = mysql_query($SQL);
	if (!$re) {
		$message = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $SQL;
		die($message);
	}
	mysql_free_result($re);
	//mysql_select_db($database_conn, $conn);
	//$Result1 = mysql_query($SQL, $conn) or die(mysql_error());

	$GoTo = $_SERVER['PHP_SELF'] . "?idu=" . $_SESSION['idu'];

	/* if (isset($_SERVER['QUERY_STRING'])) {
	  $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
	  $deleteGoTo .= $_SERVER['QUERY_STRING'];
	  } */
	header(sprintf("Location: %s", $GoTo));
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>TURed
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="StyleSheet" href="../../lib/css/style.css" type="text/css"/>
		<script>
			function carga(){
				document.getElementById("btn_go").style.visibility = "hidden";
				document.getElementById("btn_edit").style.visibility = "hidden";
				document.getElementById("divtcname").style.display = "none";
				//document.getElementById("sel_kw").style.display = "none";
				document.getElementById("btn_edit").innerHTML = "editar";  
				tc_estandar= new Array()
				
<?php
$re = mysql_query("SELECT temas.idTema, Count(EstandaresDeTema.idEstandar) AS estandares
		FROM temas INNER JOIN EstandaresDeTema ON temas.idTema = EstandaresDeTema.idTema
		GROUP BY temas.idTema, temas.idUsuario
		HAVING (((temas.idUsuario)=" . $_SESSION['idu'] . "))");
if (!$re) {
	$message = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $query;
	die($message);
}
$totalRows_tc = 0;

while ($f = mysql_fetch_assoc($re)) {	
	echo'tc_estandar["' . $f['idTema'] . '"]=' . $f['estandares'] . ';';
}
?>
	}

	function actualiza_tc(){
		var selIndex = document.getElementById('sel_tc').selectedIndex;
		var sel_tc=document.getElementById('sel_tc');
		var sel_kw=document.getElementById('sel_kw');
		if (selIndex) {
			document.getElementById("btn_go").style.visibility = "visible";
			document.getElementById("btn_edit").style.visibility = "visible";
		}
		else {
			document.getElementById("btn_go").style.visibility = "hidden";
			document.getElementById("btn_edit").style.visibility = "hidden";
		}
		document.getElementById("tcname").value  = sel_tc.options[selIndex].text;
		//document.getElementById("kw").value  = sel_kw.options[selIndex].text;
		document.getElementById("idtc").value=sel_tc.options[selIndex].value;
		document.getElementById("btn_add").innerHTML="añadir";
		document.getElementById("btn_edit").innerHTML="editar";
		document.getElementById("divtcname").style.display = "none";
		document.getElementById("livesearch").innerHTML="";
	}

	function add_tc(){
		if (document.getElementById("btn_add").innerHTML=="añadir"){
			document.getElementById("btn_add").innerHTML = "insertar";  
		}
		else {
			document.forms["form1"].submit();
		}
		document.getElementById("accion").value="add";
		document.getElementById("divtcname").style.display = "block";
		document.getElementById("tcname").value  ="";
		document.getElementById("kw").value  ="";
		document.getElementById("btn_edit").innerHTML="editar";
	}
	function edit_tc(){
		if (document.getElementById("btn_edit").innerHTML=="editar"){
			document.getElementById("btn_edit").innerHTML = "actualizar";  
		}
		else {document.forms["form1"].submit();
		}
		var selIndex = document.getElementById('sel_tc').selectedIndex;
		var sel_tc=document.getElementById('sel_tc');
		//document.getElementById("tcname").value  = sel_tc.options[selIndex].text;
		//document.getElementById("kw").value  = sel_tc.options[selIndex].text;
		document.getElementById('idtc').value=sel_tc.options[selIndex].value;
		document.getElementById("divtcname").style.display = "block";
		document.getElementById("accion").value="edit";
		document.getElementById("btn_add").innerHTML="añadir"
	}

	function showResult(str){
		if (str.length==0)
		{ 
			document.getElementById("livesearch").innerHTML="";
			document.getElementById("livesearch").style.border="0px";
			return;
		}
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
				//document.getElementById("livesearch").style.border="1px solid #A5ACB2";
			}
		}
		xmlhttp.open("GET","getdata.php?tcname="+str,true);
		xmlhttp.send();
	}
	function valid_delete(){
		//alert("hello world");
		var sel_tc=document.getElementById('sel_tc');
		var selIndex = document.getElementById('sel_tc').selectedIndex;	
		var ArrIndex = String(sel_tc.options[selIndex].value);
		document.getElementById('idtc').value=sel_tc.options[selIndex].value;
		if (tc_estandar[ArrIndex]== null) {if(confirm('¿Deseas borrar el registro seleccionado?')){document.forms["form1"].submit();};}
		else {alert ("Debes eliminarlo primero del árbol de estándares");}
	}

		</script>
	</head>

	<body onload="carga()">

		<div id="wrapper">

			<div id="header">

			</div>

			<div id="menu">
				<ul>
					<li><a href="../..//modulos/loged/loged.php" name="home">Pagina de Inicio</a></li>
					<li><a href="../../modulos/mensajesPrivados/bandejaDeEntrada.php" name="bandejaDeEntrada">Bandeja De Entrada</a></li>
					<li><a href="../../modulos/misTutorias/misTutorias.php" name="misTutorias">Mis Tutorias</a></li>
					<li><a href="../../modulos/solicitudDeTutoria/solicitudDeTutoria.php" name="solicitudDeTutoria">Solicitud de Tutoria</a></li>
					<li><a href="../alta_en_arbol/index.php?uid=<?php echo $_SESSION['idUsuario']; ?>" name="misTemasDeCatalogo">Temas de Catalogo</a></li>
				</ul>
			</div>

			<div id="sidebar">
				<div id="feed">
					<a class="feed-button" href="../../modulos/loged/cerrarSesion.php">Cerrar Sesion</a>
				</div>

				<div id="misDatos">
					<p><?php echo $_SESSION['nombre']; ?></p>
					<?php
					$imagen = $_SESSION['idUsuario'] . ".jpg";

					if (!file_exists("../../avatares/" . $imagen)) {
						$imagen = "default.jpg";
					}

					echo '<img src="../../avatares/' . $imagen . '"';
					echo 'alt="Click para subir un nuevo avatar." />';
					?>
				</div>

				<div id="sidebar-bottom"></div>
			</div>


			<div id="content" style="">

				<h3>En esta sección podrás dar de alta los temas que puedes tutorar y poterioriomente integrarlos en el árbol de estándares <a href="index.php"><img src="img/tree_small.jpg" alt="regresar al arbol" width="45" height="37" border="0" /></a></h3>
				<br/><br/>
				<form id="form1" name="form1" method="get" action="<?php echo $_SERVER['PHP_SELF'] . "?idu=" . $_SESSION['idu']; ?>" >
					<label id="lbltc">Seleccione tema de catálogo</label>        <p>
						<select name="sel_tc" id="sel_tc" onchange="actualiza_tc()">
							<option value="-1">---</option>
							<?php
							$q = "SELECT idTema,nombre FROM temas WHERE idUsuario = " . $_SESSION['idu'];
							$re = mysql_query($q);
							if (!$re) {
								$message = 'Invalid query: ' . mysql_error() . "\n";
								$message .= 'Whole query: ' . $q;
								die($message);
							}
							$totalRows_tc = 0;
							while ($f = mysql_fetch_assoc($re)) {
								$value = $f['idTema'];
								$texto = $f['nombre'];
								echo'<option value="' . $value . '">' . $texto . '</option>';
								$totalRows_tc++;
							}
							?>
						</select>
<!--									<select name="sel_kw" id="sel_kw">
							<option value="-1">---</option>
						<?php
						if (mysql_num_rows($re) > 0) {
							$totalRows_tc = 0;
							mysql_data_seek($re, 0);
							while ($f = mysql_fetch_assoc($re)) {
								$value = $f['idTema'];
								//$texto=$f['kw'];
								echo'<option value="' . $value . '">' . $texto . '</option>';
								$totalRows_tc++;
							}
						}
						mysql_free_result($re);
						?>
						</select>-->
					</p>

					<p>
						<button type="button" id="btn_add"  onclick="add_tc()" >añadir</button>
						<button type="button" id="btn_edit" onclick="edit_tc()">editar</button>
						<button type="button" name="btn_go" id="btn_go" onclick="valid_delete()">eliminar</button>
					</p>

					<div id="divtcname">
						<p>Nombre del tema de catálogo:
							<input name="tcname" type="text" id="tcname" onkeyup="showResult(this.value)" size="60"/>
						</p>
					</div>
					<div id="livesearch"></div>


					<label for="tcname"></label>
					<input name="idu"  id="idu"  type="hidden" value="<?php echo $_SESSION['idu'] ?>" />
					<input name="idtc" id="idtc" type="hidden" value="1" />
					<input name="accion" id="accion" type="hidden" value="del" />  
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