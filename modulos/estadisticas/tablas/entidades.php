<?php
include '../../../configuracion.php';
header('Content-Type: text/html; charset=UTF-8');

$db = dameConexion();

if ($db->connect_errno) {
	printf($db->connect_error);
	exit();
}
$buscaEntidades = sprintf("
            select 
                    Entidades.nombre, count(*) as cuantos
                    from 
                    Entidades, Usuarios 
                    where 
                    Entidades.idEntidad = Usuarios.idEntidad 
                    group by 
                    Entidades.idEntidad 
                    order by 
                    Entidades.nombre;");
$resultadoDeEntidades = $db->query($buscaEntidades);
?>
<center>
	<table border="1"> 
		<thead>
		<tr>
			<td>
				Entidad
			</td>
			<td>
				Usuarios
			</td>
		</tr>
		</thead>
		<tbody>
		<?php
		while ($resultadoDeEntidades && $filaDeEntidades = $resultadoDeEntidades->fetch_assoc()) {
			echo '<tr>';
			echo '<td>';
			echo '<a title="lib/php/buscaUsuarios.php?busca=entidad&entidad=' . $filaDeEntidades['nombre'] . '">';
			echo $filaDeEntidades['nombre'];
			echo '</a>';
			echo '</td>';
			echo '<td>';
			echo $filaDeEntidades['cuantos'];
			echo '</td>';
			echo '</tr>';
		}
		?>
		</tbody>
	</table>
</center>
