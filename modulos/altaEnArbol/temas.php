<?php require_once('../../Connections/esviap_conn.php'); ?>
<head>
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<?php
$valor=$_GET['valor'];
$v2=$_GET['v2'];
$re=mysql_query("SELECT * FROM tree WHERE id_UD = '".$valor."'". " and Id_grado=".$v2);
echo'<select id="tema[]" name="tema[]" size="15" multiple="multiple" onchange="llamarAjaxGET_elegidos()>"';
echo'<option >seleccione tema</option>';
while($f=mysql_fetch_array($re)){
  echo'<option value="'.$f['Id_reactivo'].'">'.htmlentities($f['Descrip_Mapeo']).'</option>';
  }
echo'</select>';
?>
<label>
<input type="submit" name="add" id="Add" value="A&ntilde;adir a mis temas de cat&aacute;logo" />
</label>
