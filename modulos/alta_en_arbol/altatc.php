<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO user_tema (user, tema, temacatalogo) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['idu'], "int"),
                       GetSQLValueString($_POST['idtema'], "int"),
                       GetSQLValueString($_POST['newtc'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "altatc.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset2 = "11";
if (isset($_GET['idu'])) {
  $colname_Recordset2 = $_GET['idu'];
}
$idtema_Recordset2 = "148";
if (isset($_GET['ude'])) {
  $idtema_Recordset2 = $_GET['ude'];
}
mysql_select_db($database_conn, $conn);
$query_Recordset2 = sprintf("SELECT usuarios.nombre, tree.Grado, tree.Nivel, tree.Asignatura, tree.Unidad_Diagnostica, tree.Descrip_Mapeo, usuarios.idu, tree.Id_reactivo, user_tema.temacatalogo, user_tema.idTema FROM usuarios INNER JOIN (user_tema INNER JOIN tree ON user_tema.tema = tree.Id_reactivo) ON usuarios.idu = user_tema.user WHERE (usuarios.idu=%s and  user_tema.tema = %s)", GetSQLValueString($colname_Recordset2, "int"),GetSQLValueString($idtema_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $conn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- ('+nm+') el tema de catálogo es requerido.\n'; }
    } if (errors) alert('Se encontraron inconsistencias:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
</script>
</head>

<body>
<h4 align="center">M&oacute;dulo: registro de temas de cat&aacute;logo</h4>
<p>
  <?php if ($totalRows_Recordset2>0){?>
</p>

<table width="100%" border="1">
  <tr>
    <th>Nombre de tutor</th>
    <th>Grado</th>
    <th>Asignatura</th>
    <th>Unidad diagnóstica</th>
  </tr>
  <tr>
    <td align="center"><?php echo htmlentities($row_Recordset2['nombre']); ?></td>
    <td align="center"><?php echo htmlentities($row_Recordset2['Grado']); ?> de <?php echo $row_Recordset2['Nivel']; ?></td>
    <td align="center"><?php echo htmlentities($row_Recordset2['Asignatura']); ?></td>
    <td align="center"><?php echo htmlentities($row_Recordset2['Unidad_Diagnostica']); ?></td>
  </tr>
</table>
<br />
<table width="100%" border="1">
  <tr>
    <th >Unidad diagnóstica específica</th>
  </tr>
  <tr>
    <td align="center"><?php echo htmlentities($row_Recordset2['Descrip_Mapeo']); ?></td>
  </tr>
</table>
<?php  }
else { echo "<h3>No has capturado temas de catálogo, por favor a&ntilde;ade tu primer tema</h3>";}
 ?>

<br />
<table width="100%" border="1">
  <tr>
    <th >Temas de catálogo</th>
  </tr>
  <?php do { ?>
    <tr>
      <td ><?php echo htmlentities($row_Recordset2['temacatalogo']); ?></td>
    </tr>
    <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
<tr>
    <td colspan="4" align="center"><form id="form1" name="form1" method="POST" >
      <p>Deseo añadir el siguiente tema de catálogo:
        <input name="idu" type="hidden" id="idu" value="<?php echo $_GET['idu']; ?>" />
        <input name="idtema" type="hidden" id="idtema" value="<?php echo $_GET['ude']; ?>" />
        <label for="newtc"></label>
        <br />
        <textarea name="newtc" cols="86" rows="2" id="newtc"></textarea> 
        </p>
      <p>
        <input name="button" type="submit" id="button" onclick="MM_validateForm('newtc','','R');llamarAjaxGET_temas()" value="añadir" />
        <input type="hidden" name="MM_insert" value="form1" />
    </p>
    </form></td>

  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href='javascript:window.close();' class="links">cerrar p&aacute;gina</a></p>
</body>
</html>
<?php
mysql_free_result($Recordset2);
?>
