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

$colname_rs_tc = "-1";
if (isset($_GET['uid'])) {
  $colname_rs_tc = $_GET['uid'];
}
mysql_select_db($database_conn, $conn);
$query_rs_tc = sprintf("SELECT * FROM temas WHERE `user` = %s", GetSQLValueString($colname_rs_tc, "int"));
$rs_tc = mysql_query($query_rs_tc, $conn) or die(mysql_error());
$row_rs_tc = mysql_fetch_assoc($rs_tc);
$totalRows_rs_tc = mysql_num_rows($rs_tc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script>

function llamarAjaxGET_chtema(oldname,newname){
}
</script>

</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <label for="tc_list"></label>
  <select name="tc_list" id="tc_list">
    <?php
do {  
?>
    <option value="<?php echo $row_rs_tc['idTema']?>"><?php echo htmlentities($row_rs_tc['temacatalogo']);?></option>
    <?php
} while ($row_rs_tc = mysql_fetch_assoc($rs_tc));
  $rows = mysql_num_rows($rs_tc);
  if($rows > 0) {
      mysql_data_seek($rs_tc, 0);
	  $row_rs_tc = mysql_fetch_assoc($rs_tc);
  }
?>
  </select>
  <button type="button" onclick="javascript:llamarAjaxGET_chtema(document.getElementById('tc_list').value,prompt('Por favor ingrese el nuevo nombre:', document.getElementById('tc_list').value))">Modificar</button>
  
</form>
</body>
</html>
<?php
mysql_free_result($rs_tc);
?>
