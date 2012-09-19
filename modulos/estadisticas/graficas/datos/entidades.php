<?php
header('Content-Type: text/html; charset=UTF-8');
include '../../../../configuracion.php';
include '../../../../lib/ofc/php-ofc-library/open-flash-chart.php';
include '../../lib/Estadisticas.php';

$db = dameConexion();

$query = sprintf("
            select 
				Entidades.nombre as entidad, count(*) as cuantos
				from 
				Entidades, Usuarios 
				where 
				Entidades.idEntidad = Usuarios.idEntidad 
				group by 
				Entidades.idEntidad 
				order by 
				Entidades.nombre;");
$result = $db->query($query);

$d = array();
$m = array();
while($row = $result -> fetch_assoc()){
	array_push($m, $row['cuantos']);
	$bar = new bar_value(0+$row['cuantos']);
	$bar->set_colour( "#".dechex(rand(100000,16777215)) );	
	$bar ->set_tooltip($row['entidad']);
	array_push($d, $bar);
}

$graph = new bar_round();
$graph->set_alpha( 0.75 );
$graph->set_values( $d );
$graph->set_on_click("muestra_tabla_entidades");

$x_axis = new x_axis();
$x_axis->set_3d(5);

$y = new y_axis();
$y->set_range(0,max($m)+10,5);

$chart = new open_flash_chart();
$chart->set_x_axis($x_axis);
$chart->set_y_axis($y);
$chart->set_title(new title('Usuarios en cada Entidad Federativa'));
$chart->add_element( $graph );

echo $chart->toPrettyString();
?>
