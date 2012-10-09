<?php
include '../../../../configuracion.php';
header('Content-Type: text/html; charset=UTF-8');

$db = dameConexion();
$asignatura = $_GET['asignatura'];

switch ($_GET['accion']) {
	case 'asignatura':
		$buscaTemas = sprintf('select 
                    Temas.idTema, Temas.nombre as tema, 
                    EstandaresDeTema.idestandar , 
                    Estandares.idAsignatura, 
                    Asignaturas.nombre as asignatura
                    from 
                    Temas, EstandaresDeTema , Estandares, Asignaturas
                    where 
                    EstandaresDeTema.idTema= Temas.idTema 
                    and 
                    Estandares.idEstandar = EstandaresDeTema.idEstandar
                    and
                    Asignaturas.idAsignatura = Estandares.idAsignatura
                    and 
                    Asignaturas.nombre="%s" group by idTema;', $asignatura);
		break;
}
$resultadoDeTemas = $db->query($buscaTemas);
?>
<center>
	<table border="1">
		<thead><td colspan="2"><?php echo $asignatura ?></td></tr></thead>
		<tbody>
			<tr>
				<td>
					ID
				</td>
				<td>
					Catálogo
				</td>
			</tr>
			<?php
			while ($resultadoDeTemas && $fila = $resultadoDeTemas->fetch_assoc()) {
				echo'<tr>';
				echo'<td>';
				echo $fila['idTema'];
				echo'</td>';
				echo'<td>';
				echo $fila['tema'];
				echo'</td>';
				echo'</tr>';
			}
			?>
		</tbody>
	</table>
</center>