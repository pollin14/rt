<?php 

$hostname_conn = "localhost";
$database_conn = "esviap";
//$username_conn = "mardebro_esviap";
//$password_conn = "Aa12345_";
$username_conn = "root";
$password_conn = "";
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db("esviap")or die(mysql_error());

//mysql_connect("localhost","mardebro_esviap","Aa12345_")or die(mysql_error());
//mysql_select_db("esviap")or die(mysql_error());
//$database_conn = "esviap";

//mysql_select_db("mardebro_esviap")or die(mysql_error());
//mysql_connect("localhost","mardebro_mood1","acceso")or die(mysql_error());
//mysql_select_db("mardebro_mood1")or die(mysql_error());

?>
