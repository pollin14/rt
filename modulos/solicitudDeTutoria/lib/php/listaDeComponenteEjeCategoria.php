<?php
header('Content-Type: text/html; charset=UTF-8');
include "../../../../configuracion.php";

define("LIMITE", 20);

$html = "";

$db = dameConexion();
$query = "select * from ComponenteEjeCategoria order by nombre;";
$result = $db -> query($query);

if(!$result){ die ("Error: ".  $query);};

while($row = $result->fetch_assoc()){
	$html .= '<option value="' . $row['idComponenteEjeCategoria'] .'"' ;
	$html .= ' title="' .$row['nombre'] . '">';
	$html .= $row['nombre'];
	$html .= '</option>';
}

$result -> free();
$db->close();
print($html);

?>
