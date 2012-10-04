<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
session_start();
$_SESSION['prev'] = htmlentities($_SERVER['REQUEST_URI']); 
$ude=$_GET["ude"]; 
$idu=$_GET["idu"];
$tcn=$_GET["tcn"];
  if ($_SESSION['modulo']=="tc") 
	{$table="EstandaresDeTema";} 
  else 
	{$table="user_kw";}
//$insql="insert into $table values(default,".$idu.",".$ude.",".$tcn.")";
$insql="insert into $table values(".$tcn.",".$ude.")";
//$isempty="SELECT EstandaresDeTema.user FROM EstandaresDeTema WHERE (((EstandaresDeTema.user)=$idu) AND ((EstandaresDeTema.id_tema)=$ude) AND ((EstandaresDeTema.id_tc)='$tcn'))";
//echo $isempty;
$isempty="select * from EstandaresDeTema where idEstandar=$ude and idTema=$tcn";
$re=mysql_query($isempty);
if (mysql_num_rows($re)<1) {
	$re=mysql_query($insql);
	//echo $insql;
}
include ("listado_tc.php")
?>
