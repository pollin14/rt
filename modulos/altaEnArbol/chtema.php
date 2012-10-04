<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
session_start();
$_SESSION['prev'] = htmlentities($_SERVER['REQUEST_URI']); 
$idu=$_GET["idu"];
$on=$_GET["on"]; 
$nn=$_GET["nn"];
	$chsql='update user_tema set temacatalogo="'.$nn.'" where user='.$idu.' and temacatalogo="'.$on.'"';
	//echo $chsql;
	if ((!is_null($on)) && (!is_null($nn))) {$re=mysql_query($chsql);}
include ("listado_tc.php")
?>
