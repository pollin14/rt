<?php

header('Content-Type: text/html; charset=UTF-8');
require '../../../../configuracion.php';
include '../../../../lib/ofc/php-ofc-library/open-flash-chart.php';
require '../../lib/Estadisticas.php';

$db = dameConexion();
$e = new Estadisticas($db);

$sinMensajes = 0 + $e->cuantasTutoriasHay() - ($e->cuantasTutoriasFinalizadasHay()+
$e->cuantasTutoriasEnDemostracionHay()+
$e->cuantasTutoriasBuscandoSinodalesHay()+
$e->cuantasTutoriasActivasHay());

$v = array(
$e->cuantasTutoriasFinalizadasHay(),
$e->cuantasTutoriasEnDemostracionHay(),
$e->cuantasTutoriasBuscandoSinodalesHay(),
$e->cuantasTutoriasActivasHay() + $sinMensajes);

$n = array("Finalizadas","En Demostración","En espera","En Proceso");

$d = array();
$len=4;

for ($i=0; $i< $len; $i++){
$slice = new pie_value(0+$v[$i], $n[$i]);
$slice->set_colour( "#".dechex(rand(10000,16777215)) );
$slice->on_click('muestra_tabla_tutorias');
array_push($d, $slice);
}

$pie = new pie();
$pie->set_animate( true );
$pie->set_label_colour( '#432BAF' );
$pie->set_alpha( 0.75 );
$pie->set_tooltip( '#label#<br>#val# (#percent#)' );
$pie->set_colours(
    array(
        '#77CC6D', // income (green)
        '#FF5973', // spend (pink)
        '#6D86CC', // profit (blue)
'#215799'	// ni idea?
    ) );

$pie->set_values( $d );

$chart = new open_flash_chart();
$chart->set_title(new title("Tutorías"));
$chart->add_element( $pie );

echo $chart->toPrettyString();
?>