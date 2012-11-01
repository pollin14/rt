<?php
include '../../../../lib/ofc/php-ofc-library/open-flash-chart.php';
include '../../../../lib/php/queries.php';
include '../../../../configuracion.php';

define ('ESPAÑOL','Español');
define ('CIENCIAS','Ciencias');
define ('MATEMATICAS','Matemáticas');
define ('SIN_CATALOGO','null');
define ('ENTIDAD','Entidad');

function cuantosDe($col,$table,$number = true){
	$ntable = array();
	$i = 0;
	
	foreach($table as $v){
		if($number){
			$ntable[$i] = $v[$col] +0;
		}else{
			$ntable[$i] = $v[$col] . "";
		}
		$i++;
	}
	return $ntable;
}


$db = dameConexion();

$tabla = dameResumen($db);

$title = new title("Asignaturas por Entidad");

$data = cuantosDe(ESPAÑOL,$tabla);

$bar = new bar_3d();
$bar->colour( '#BF3B69');
$bar->key('Español', 12);
$bar->set_values( $data );
$bar->set_on_click("muestra_tabla_resumen");

$data2 = cuantosDe(CIENCIAS,$tabla);
$bar2 = new bar_3d();
$bar2->colour( '#569654' );
$bar2->key('Ciencias', 12);
$bar2->set_values( $data2 );
$bar2->set_on_click("muestra_tabla_resumen");

$data3 = cuantosDe(MATEMATICAS,$tabla);
$bar3 = new bar_3d();
$bar3->colour( '#215799' );
$bar3->key('Matemáticas', 12);
$bar3->set_values( $data3 );
$bar3->set_on_click("muestra_tabla_resumen");

$data4 = cuantosDe(SIN_CATALOGO,$tabla);
$bar4 = new bar_3d();
$bar4->colour( '#abcdff' );
$bar4->key('Sin Asignatura', 12);
$bar4->set_values( $data4 );
$bar4->set_on_click("muestra_tabla_resumen");

$max = max( max($data) , max($data2), max($data3), max($data4));
$step = floor($max/10);

$x = new x_axis();
$x->set_3d(5);
$x ->set_labels_from_array(cuantosDe(ENTIDAD,$tabla,false));

$y = new y_axis();
$y ->set_range(0,$max, $step);

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->set_x_axis($x);
$chart->set_y_axis($y);
$chart->add_element( $bar );
$chart->add_element( $bar2 );
$chart->add_element( $bar3 );
$chart->add_element( $bar4 );
echo $chart->toString();
?>

