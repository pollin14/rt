<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
$valor=$_GET['valor'];
  $re=mysql_query("select * from dbo_Asignaturas");
  while($f=mysql_fetch_array($re)){
  echo'<option value="'.$f['Id_Asignatura'].'">'.$f['Asignatura'].'</option>';
  }
echo'</select>';
?>
