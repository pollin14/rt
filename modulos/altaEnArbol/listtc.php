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

$id_u_Recordset1 = "-1";
if (isset($_GET['idu'])) {
  $id_u_Recordset1 = $_GET['idu'];
}
mysql_select_db($database_conn, $conn);
$query_Recordset1 = sprintf("SELECT usuarios.nombre, tree.Grado, tree.Nivel, tree.Asignatura, tree.Unidad_Diagnostica, tree.Descrip_Mapeo, usuarios.idu, tree.Id_reactivo, user_tema.temacatalogo FROM usuarios INNER JOIN (user_tema INNER JOIN tree ON user_tema.tema = tree.Id_reactivo) ON usuarios.idu = user_tema.user WHERE (((usuarios.idu)=%s))", GetSQLValueString($id_u_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ESVIAP, listado de temas de catálogo</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
<h3 align="center">Espacio Virtual de aprendizaje ESVIAP</h3>
<h4 align="center">M&oacute;dulo: listado de temas de cat&aacute;logo</h4>
<p align="center">Nombre del tutor: <?php echo htmlentities($row_Recordset1['nombre']); ?></p>
<table width="100%" border="1">
  <tr bgcolor="#CCCFE6">
    <th>Grado
      </td>
    </th>
    <th>Nivel
      </td>
    </th>
    <th>Asignatura
      </td>
    </th>
    <th>Unidad Diagn&oacute;stica
      </td>
    </th>
  </tr>
  <tr>
    <td align="center"><?php echo htmlentities($row_Recordset1['Grado']); ?></td>
    <td align="center"><?php echo htmlentities($row_Recordset1['Nivel']); ?></td>
    <td align="center"><?php echo htmlentities($row_Recordset1['Asignatura']); ?></td>
    <td align="center"><?php echo htmlentities($row_Recordset1['Unidad_Diagnostica']); ?></td>
  </tr>
  <tr>
    <th align="right">Unidad Diagn&oacute;stica espec&iacute;fica </th>
    <td colspan="3"><?php echo $row_Recordset1['Descrip_Mapeo']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <th align="right">Tema de catálogo</th>
    <td colspan="2"><?php echo $row_Recordset1['temacatalogo']; ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href='javascript:window.close();'>cerrar p&aacute;gina</a></p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
