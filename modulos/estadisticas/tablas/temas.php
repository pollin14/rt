<?php
include '../../../configuracion.php';
header('Content-Type: text/html; charset=UTF-8');

$db = dameConexion();

$cuentaTemas = sprintf('select count(*) as cuantos from Temas;');
$resultadoDeCuentaTemas = $db->query($cuentaTemas);
$dato = $resultadoDeCuentaTemas->fetch_assoc();
$totalTemas = $dato['cuantos'];

$cuentaTemasPorAsignatura = sprintf('
	select count(distinct EstandaresDeTema.idTema) as cuantos,
	Asignaturas.nombre as asignatura
	from
	Temas, EstandaresDeTema , Estandares, Asignaturas
	where
	EstandaresDeTema.idTema= Temas.idtema
	and
	Estandares.idEstandar = EstandaresDeTema.idEstandar
	and
	Asignaturas.idAsignatura = Estandares.idAsignatura
	group by
	asignatura
	;');
$resultadoDeCuentaTemasPorAsignatura = $db->query($cuentaTemasPorAsignatura);
?>


<table class="datos">
	<thead>
	<tr>
		<td>
			Catálogos
		</td>
		<td>
			<?php
			print ($totalTemas);
			?>
		</td>

	</tr>
	</thead>
	<tbody>
	<?php
	$count = 0;
	while ($resultadoDeCuentaTemasPorAsignatura && $fila = $resultadoDeCuentaTemasPorAsignatura->fetch_assoc()) {
		$count += $fila['cuantos'];
		echo'<tr>';
		echo '<td>';
		echo '<a title="lib/php/buscaTemas.php?accion=asignatura&asignatura=' . $fila['asignatura'] . '">';
		echo $fila['asignatura'];
		echo '</a>';
		echo '</td>';
		echo '<td>';
		echo $fila ['cuantos'];
		echo '</td>';
		echo'</tr>';
	}
	echo '<tr><td>Sin Asignatura</td></td><td>' . ($totalTemas - $count) . '</td></tr>';
	?>
	</tbody>
</table>
