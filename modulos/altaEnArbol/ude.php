<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
session_start();
$ud=$_GET['ud'];
$gr=$_GET['gr'];
$as=$_GET['as'];
if (isset($_GET['uden'])){
	$uden=$_GET['uden'];
	$qmax="select max(Id_reactivo) as max from dbo_reactivos";
	$re=mysql_query($qmax);
	$f=mysql_fetch_array($re);
	$max=$f['max']+1;
	$qins="insert dbo_reactivos values($max,$gr,'$as',null,$ud,null,'$uden')";
	//echo $qins;
	$isempty="SELECT Id_reactivo FROM dbo_reactivos WHERE (Id_Grado=$gr AND Id_Asignatura='$as' AND Id_UD='$ud') AND (Descrip_Mapeo='$uden')";
        //echo $isempty;
	$re=mysql_query($isempty);
	if (mysql_num_rows($re)<1) {
		$re=mysql_query($qins);
	}
}
//$q_ude= "SELECT Id_reactivo,Descrip_Mapeo FROM dbo_reactivos WHERE id_UD = '".$ud."'". " and Id_grado=".$gr. " and Id_Asignatura='".$as."'";
$q_ude ="SELECT estandares.idEstandar, estandares.descripcion, estandares.idPeriodo, estandares.idAsignatura, estandares.idComponenteEjeCategoria
FROM estandares
GROUP BY estandares.idEstandar, estandares.descripcion, estandares.idPeriodo, estandares.idAsignatura, estandares.idComponenteEjeCategoria
HAVING (((estandares.idPeriodo)=$gr) AND ((estandares.idAsignatura)=$as) AND ((estandares.idComponenteEjeCategoria)=$ud))";
//echo $q_ude;
$re=mysql_query($q_ude);
//echo'<select id="ude" name="ude" multiple="multiple" size="15" >';
//if ($gr==0) {
//}

echo'<select id="ude" name="ude" size="9" >';
//echo'<option>seleccione UD espec&iacute;fica</option>'."\n";
while($f=mysql_fetch_array($re)){
  echo '<option value="'.$f['idEstandar'].'">'.htmlentities($f['descripcion']).'</option>'."\n";
  }
echo'</select>';
?>
<button type="button" onclick="llamarAjaxGET_temas()">
    <?php 
	if ($_SESSION['modulo']=="tc") 
	{echo "a&ntilde;adir a mi cat&aacute;logo";} 
	else 
	{echo "a&ntilde;adir a KeyWords del estandar que seleccion&eacute;";} ?>


</button>
