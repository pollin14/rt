<?php
header('Content-Type: text/html; charset=UTF-8');
include '../../../../configuracion.php';
include '../../../../lib/ofc/php-ofc-library/open-flash-chart.php';
include '../../lib/Estadisticas.php';

$db = dameConexion();

$query = sprintf("
select entidades.nombre as entidad, count(*) as cuantos
from
(usuarios left join entidades using(idEntidad))
group by entidades.nombre;");
$result = $db->query($query);

$barras = array();
$datos = array();
$entidades = array();

while($row = $result -> fetch_assoc()){
$bar = new bar_value(0+$row['cuantos']);
$bar->set_colour( "#".dechex(rand(100000,16777215)) );	
$bar->set_tooltip($row['entidad']);
array_push($datos, $row['cuantos']+0); //datos
array_push($entidades,$row['entidad']);
array_push($barras, $bar); //barras
}

$graph = new bar_round();
$graph->set_alpha( 0.75 );
$graph->set_values( $barras );
$graph->set_on_click("muestra_tabla_entidades");

$max = max($datos);
$step = floor($max/10);

$x_axis_labels = new x_axis_labels();
$x_axis_labels->set_vertical();
$x_axis_labels->set_size(12);
$x_axis_labels->set_labels($entidades);

$x = new x_axis();
$x->set_labels($x_axis_labels);
$x->set_3d(5);

$y = new y_axis();
$y->set_range(0,$max,$step);

$y_legend = new y_legend('Usuarios');
$y_legend->set_style('{font-size: 20px; color: #770077}');

$chart = new open_flash_chart();
$chart->set_x_axis($x);
$chart->set_y_axis($y);
$chart->set_y_legend($y_legend);
$chart->set_title(new title('Usuarios en cada Entidad Federativa'));
$chart->add_element( $graph );

echo $chart->toPrettyString();
?>