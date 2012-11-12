<?php
include '../../configuracion.php';
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$ubicacion="local";
//if ($ubicacion=="local"){
//	$database_esviap_conn = "tutorias";
//	$username_esviap_conn = "rt";}
//	
//else {	
	$database_esviap_conn = DB;
	$username_esviap_conn = USER;
//}
$hostname_esviap_conn = HOST;
$password_esviap_conn = PASSWORD;
$esviap_conn = mysql_pconnect($hostname_esviap_conn, $username_esviap_conn, $password_esviap_conn) or trigger_error(
mysql_error(),E_USER_ERROR); 
$database_conn=$database_esviap_conn;
$conn=$esviap_conn;
mysql_select_db($database_esviap_conn);
mysql_query("SET NAMES 'utf8'"); 
?>