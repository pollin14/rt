<?php
header('Content-Type: text/xml; charset=UTF-8');

include "../../configuracion.php";
include "../../lib/php/utils.php";

$idTutoria = $_POST['idTutoria'];
$idEtapa = 1;

$fechaActual = getActualDate();

$xml = "";

$db = dameConexion();

if(!$db){die ($db->connect_error);}


//buscamos la ultima etapa
$query = sprintf('select Max(idEtapa) as ultimaEtapa 
    from Historial where idTutoria = %d',$idTutoria);

$result = $db -> query($query);

//como usa funcion de agregado (MAX) siempre nos regresara
// por lo menos una fila.
if(!$result ){
    $xml = '<?xml version="1.0" encoding="utf-8"?><mensajes>';
    $xml .= "<errro><![CDATA[";
    $xml .= "Error: " . $query;
    $xml .= "]]></error>";
    $xml . "</mensajes>";
    print($xml);
    $db ->close();
    exit();
}
$row = $result->fetch_assoc();
$idEtapa =  ($row['ultimaEtapa']=== null)? 1: $row['ultimaEtapa'] ;
$result -> free();

//fin de busqueda de etapa

$query = sprintf("select distinct h.idUsuario,h.fecha,h.mensaje,h.idEtapa, u.nick
    from Historial as h, Usuarios as u
        where 
            h.idTutoria = %d and 
            h.idUsuario = u.idUsuario and 
            h.idEtapa = %d and
            h.autorizacion = true
        order by fecha;",$idTutoria,$idEtapa);
$result = $db ->query($query);

if(! $result){
    $xml = '<?xml version="1.0" encoding="utf-8"?><mensajes>';
    $xml .= "<errro><![CDATA[";
    $xml .= "Error: " . $query;
    $xml .= "]]></error>";
    $xml . "</mensajes>";
    print($xml);
    $db ->close();
    exit();
}

$xml = '<?xml version="1.0" encoding="utf-8"?><mensajes>';

while ($row = $result -> fetch_assoc()){
    $xml .= '<mensaje '. 
            'idUsuario="'. $row['idUsuario'] .'" '.
            'nick="' .$row['nick'] . '" ' .
            'fecha="'. $row['fecha'] . '">';
    $xml .= '<![CDATA[';
    $xml .= $row['mensaje'];
    $xml .= ']]>';
    $xml .= "</mensaje>";
    $idEtapa = $row['idEtapa'];
}

 $result = $db->query('
	 select count(*) as numPro 
	 from Productos 
	 where idTutoria = ' . $idTutoria . ';');

 if (!$result) die ("Error: " .$db->error);
 
 $row = $result->fetch_row();

 $xml .= "<productosnuevos>" . $row[0] . "</productosnuevos>";

$xml .= '<ultimaverificacion ultimoMili="0">'.$fechaActual.'</ultimaverificacion>';
$xml .= '<ultimaetapa>' . $idEtapa .'</ultimaetapa>' ;
$xml .= '</mensajes>';

if ($result -> free());

print($xml);
?>
