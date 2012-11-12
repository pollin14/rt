<?php
header('Content-Type: text/html; charset=UTF-8');
include "../../../../configuracion.php";

$idCEC = $_POST['idCEC']; // idComponenteEjeCategoria

$db = dameConexion();
$query = sprintf('select * from Estandares where idComponenteEjeCategoria = %d order by descripcion;', $idCEC);
$result = $db->query($query);

if(!$result) die("Error. " . $db->error);

$html = "";
while($row = $result ->fetch_assoc()){
	$html .= '<option value="' . $row['idEstandar'] . '" title="'. $row['descripcion'] .'">';
	$html .= $row['descripcion'];
	$html .= '</option>';
}

$result->free();
$db->close();
print($html);

?>
