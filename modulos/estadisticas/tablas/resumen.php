<?php

include '../../../configuracion.php';
include '../../../lib/php/queries.php';

function imprimeFila($fila){
	echo '<tr>';
	foreach($fila as $v){
		echo '<td>'.$v .'</td>';
	}
	echo '<tr>';
}
?>
<table>
	<thead>
		<tr>
			<td>Entidad</td>
			<td>Español</td>
			<td>Ciencias</td>
			<td>Matemáticas</td>
			<td>Sin Asignatura</td>
		</tr>
	</thead>
	<tbody>
		<?php
			$db = dameConexion();
			$tabla = dameResumen($db);
			
			foreach($tabla as $v){
				imprimeFila($v);
			}
		?>
	</tbody>
</table>
