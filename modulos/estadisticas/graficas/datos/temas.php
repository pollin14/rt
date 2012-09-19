<?php
header('Content-Type: text/html; charset=UTF-8');
include '../../../../configuracion.php';
include '../../../../lib/ofc/php-ofc-library/open-flash-chart.php';
include '../../lib/Estadisticas.php';

$db = dameConexion();
$e = new Estadisticas($db);

$totalDeTemas = $e->cuantosTemasHay();

$cuentaTemasPorAsignatura = 
	sprintf('
		select count(distinct EstandaresDeTema.idTema) as cuantos,
			Asignaturas.nombre as asignatura
		from 
			Temas, 
			EstandaresDeTema,
			Estandares, 
			Asignaturas
		where 
			EstandaresDeTema.idTema= Temas.idTema 
		and 
			Estandares.idEstandar = EstandaresDeTema.idEstandar
		and
			Asignaturas.idAsignatura = Estandares.idAsignatura
		group by asignatura;');
$result = $db->query($cuentaTemasPorAsignatura);

$d = array();
$cont = 0;
while($row = $result -> fetch_assoc()){
	$cont += $row['cuantos'];
	$slice = new pie_value(0+$row['cuantos'], $row['asignatura']);
    $slice->set_colour( "#".dechex(rand(1000000,16777215)) );	
	$slice->on_click('muestra_tabla_temas');
	array_push($d, $slice);
}

$slice = new pie_value($totalDeTemas - $cont,'Sin asignatura');
$slice->on_click('muestra_tabla_temas');
array_push($d,$slice);

$pie = new pie();
$pie->set_animate( true );
$pie->set_label_colour( '#432BAF' );
$pie->set_alpha( 0.75 );
$pie->set_tooltip( '#label#<br>#val# (#percent#)' );
$pie->set_colours(
    array(
        '#77CC6D',    // income (green)
        '#FF5973',    // spend (pink)
        '#6D86CC',    // profit (blue)
		'#215799'		// ni idea?
    ) );

$pie->set_values( $d );

$chart = new open_flash_chart();
//Si se activa title tira un error.
//$chart->set_title('Temas');
$chart->set_title(new title("Catálogos"));

$chart->add_element( $pie );

echo $chart->toPrettyString();
?>
