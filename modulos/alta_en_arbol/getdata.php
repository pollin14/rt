<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
$colname_rs_temas = "-1";
if (isset($_GET['tcname'])) {
  $colname_rs_temas = $_GET['tcname'];
}
mysql_select_db($database_conn, $conn);
$query_rs_temas = "select nombre from temas where nombre like \"%$colname_rs_temas%\"";
$rs_temas = mysql_query($query_rs_temas, $conn) or die(mysql_error());
$row_rs_temas = mysql_fetch_assoc($rs_temas);
$totalRows_rs_temas = mysql_num_rows($rs_temas);
?>
<script>
function cambia_tcname(objeto){
//alert (objeto.firstChild.nodeValue);
}
</script>

<table width="200" border="0">
  <?php $i=1; do { ?>
    <tr>
      <td><label id="lbl<?php echo $i;?>" onclick="cambia_tcname(this);"> <?php echo htmlentities($row_rs_temas['nombre']); ?> </label></td>
    </tr>
    <?php $i++;} while ($row_rs_temas = mysql_fetch_assoc($rs_temas)); ?>
</table>
<p>&nbsp;</p>
<?php
mysql_free_result($rs_temas);
?>
