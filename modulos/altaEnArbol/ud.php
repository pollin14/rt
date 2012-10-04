<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
$gr=$_GET['gr'];
$as=$_GET['as'];
if (isset($_GET['udn'])){
	$udn=$_GET['udn'];
	$qins="insert ud values(default,$gr,'$as',null,'$udn')";
	//echo $qins;
	$isempty="SELECT Id FROM ud WHERE (Id_Grado=$gr AND id_asignatura='$as' AND Unidad_Diagnostica='$udn')";
        //echo $isempty;
	$re=mysql_query($isempty);
	if (mysql_num_rows($re)<1) {
		$re=mysql_query($qins);
	}

}

//$qud="SELECT Id,Unidad_Diagnostica FROM ud WHERE id_asignatura = '".$as."'". " and Id_grado=".$gr." group by Id";
$qud="SELECT ComponenteEjeCategoria.idComponenteEjeCategoria, ComponenteEjeCategoria.nombre, estandares.idPeriodo, estandares.idAsignatura FROM estandares INNER JOIN ComponenteEjeCategoria ON estandares.idComponenteEjeCategoria = ComponenteEjeCategoria.idComponenteEjeCategoria GROUP BY ComponenteEjeCategoria.idComponenteEjeCategoria, ComponenteEjeCategoria.nombre, estandares.idPeriodo, estandares.idAsignatura HAVING (((estandares.idPeriodo)=$gr) AND ((estandares.idAsignatura)=$as));";
//echo $qud;
$re=mysql_query($qud);
?>
<select id="ud" name="ud" onchange=llamarAjaxGETude()>
<option  value="-1">---</option>
<?php
while($f=mysql_fetch_array($re)){
  echo'<option value="'.$f['idComponenteEjeCategoria'].'">'.htmlentities($f['nombre']).'</option>';
 // echo'<option value="'.$f['Id'].'">'.$f['nombre'].'</option>';
  }
?>
</select> 
