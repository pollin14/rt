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

mysql_select_db($database_conn, $conn);
$query_Recordset1 = "SELECT * FROM user_tema";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

function codifica ($busca){
$origen= utf8_decode( "áéíóúÁÉÍÓÚñÑöÖüÜ");
//echo $origen."<br />\n";
$destino="aeiouaeiounnoouu";
//echo $destino."<br />\n";
//$busca=utf8_decode($busca);
$busca=strtolower($busca);
//echo $busca."<br />\n";
//echo $busca."\n";
$resp="";
for ($i=0;$i<strlen($busca);$i++){
	//Echo "i=$i<br />\n";
	$car=substr($busca,$i,1);
	//Echo "car=$car<br />\n";
	$pos=stripos($origen,$car);
	//Echo "pos=$pos<-<br />\n";
	if ($pos || $pos===0)
	     { //echo "found, ";
		 $resp=$resp.substr($destino,$pos,1);}
	else { //echo "not found, ";
	$resp=$resp.substr($busca,$i,1);}
	//Echo "resp=$resp<br />\n";
}
return $resp;
}

?>
<table width="200" border="1">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php $idtc=$row_Recordset1['idTema']; echo $idtc; ?></td>
      <td><?php echo $row_Recordset1['temacatalogo']; ?></td>
      <td>
		<?php $coded=codifica($row_Recordset1['temacatalogo']); 
        echo $coded; 
        $qupd = "update user_tema set coded=\"".$coded."\" where idTema =".$idtc;
        echo $qupd;
        $rsupd = mysql_query($qupd, $conn) or die(mysql_error());
        ?>
      </td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php
mysql_free_result($Recordset1);
?>

