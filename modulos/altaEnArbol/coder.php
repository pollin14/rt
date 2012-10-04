<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php 
//$table="user_tema"; $key="idtc"; $paraconvertir="temacatalogo";
//$table="user_kw"; $key="idtc"; $paraconvertir="temacatalogo";
//$table="estandar"; $key="Id"; $paraconvertir="Estandard";
$table="ComponenteEjeCategoria"; $key="Id"; $paraconvertir="Estandard_name";

function codifica ($busca){
$origen= utf8_decode( "áéíóúÁÉÍÓÚñÑöÖüÜ");
//echo $origen."<br />\n";
$destino="aeiouaeiounnoouu";
//echo $destino."<br />\n";
//$busca=utf8_decode($busca);
$busca=strtolower($busca);
//echo $busca."<br />\n";
//echo $busca."\n";
$resp="";
for ($i=0;$i<strlen($busca);$i++){
	//Echo "i=$i<br />\n";
	$car=substr($busca,$i,1);
	//Echo "car=$car<br />\n";
	$pos=stripos($origen,$car);
	//Echo "pos=$pos<-<br />\n";
	if ($pos || $pos===0)
	     { //echo "found, ";
		 $resp=$resp.substr($destino,$pos,1);}
	else { //echo "not found, ";
	$resp=$resp.substr($busca,$i,1);}
	//Echo "resp=$resp<br />\n";
}
return $resp;
}
  
mysql_select_db($database_conn, $conn);
$query_Recordset1 = "SELECT * FROM $table";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
  
do {  
	  $idtc=$row_Recordset1[$key]; 
	  //echo $idtc;  
	  //echo $row_Recordset1['temacatalogo']; 
	  $coded=codifica($row_Recordset1[$paraconvertir]); 
      //echo $coded; 
      $qupd = "update $table set coded=\"".$coded."\" where $key =".$idtc;
      //echo $qupd;
      $rsupd = mysql_query($qupd, $conn) or die(mysql_error());
}
while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));

mysql_free_result($Recordset1);

?>