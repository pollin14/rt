<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
session_start();
$_SESSION['prev'] = htmlentities($_SERVER['REQUEST_URI']); 
$temas=$_GET["ude"]; 
$idu=$_GET["idu"];
$ide=$_GET["ide"];
$idtc=$_GET["idtc"];
	//$delsql="delete from user_tema WHERE user_tema.id=$idtc";
	$delsql="delete FROM EstandaresDeTema WHERE idTema =$idtc and idEstandar=$ide";
//	echo $delsql;
	$re=mysql_query($delsql);
include ("listado_tc.php")
?>


