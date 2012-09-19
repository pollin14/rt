<?php
header('Content-Type: text/html; charset=UTF-8');
include '../../../../configuracion.php';
include '../../../../lib/ofc/php-ofc-library/open-flash-chart.php';
include '../../lib/Estadisticas.php';

$db = dameConexion();
$e = new Estadisticas($db);
$pas = 10;
$d = array();
$v = array(
	$e->cuantasMujeresHay(),
	$e->cuantosHombresHay(),
	$e->cuantosTutoresHay(),
	$e->cuantosTutoradosHay(),
	);
$n = array("Mujeres","Hombres","Tutores","Tutorados");
$len = 4;
//echo $d;
//exit();
for($i=0; $i< $len;$i++){
	$bar = new bar_value(0 + $v[$i] );
    $bar->set_colour( "#".dechex(rand(10000,16777215)) );
	$bar ->set_tooltip($n[$i] . "<br>" . $v[$i]);	
	array_push($d, $bar);
}

$graph = new bar_glass();
$graph->set_alpha( 0.75 );
$graph->set_values( $d );
$graph->set_on_click("muestra_tabla_usuarios");

$x_axis = new x_axis();
$x_axis->set_3d(5);

$y_axis = new y_axis();
$alto=max( array($e->cuantosHombresHay(),$e->cuantasMujeresHay()))+5;
$y_axis->set_range(0,$alto,5);

$chart = new open_flash_chart();
$chart->set_x_axis($x_axis);
$chart->set_y_axis($y_axis);
$chart->set_title(new title('Usuarios de la Plataforma'));
$chart->add_element( $graph );

echo $chart->toPrettyString();
?>