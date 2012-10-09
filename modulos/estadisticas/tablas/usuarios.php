<?php
include '../../../configuracion.php';
header('Content-Type: text/html; charset=UTF-8');

$db = dameConexion();

if ($db->connect_errno) {
	printf($db->connect_error);
	exit();
}
// numero de usuarios
$cuentaUsuarios = sprintf('select count(*) as cuantos from Usuarios');
$resultadoDeCuentaUsuarios = $db->query($cuentaUsuarios);
$filaDeCuentaUsuarios = $resultadoDeCuentaUsuarios->fetch_assoc();
//usuarios Hombres o Mujeres
$cuentaUsuariosPorSexo = sprintf('select sexo, count(*) as cuantos from Usuarios group by sexo;');
$resultadoDeCuentaUsuariosPorSexo = $db->query($cuentaUsuariosPorSexo);
//tutores
$cuentaTutores = sprintf("select count(distinct idUsuario) as cuantos from Temas where autorizado=1;");
$resultadoDeCuentaTutores = $db->query($cuentaTutores);
//tutorados
$cuentaTutorados = sprintf("select count(distinct estudiante) as cuantos from Tutorias ;");
$resultadoDeCuentaTutorados = $db->query($cuentaTutorados);
?>

<center>
	<table border="1">
		<tr>
			<td>
				<a title="lib/php/buscausuarios.php?sexo=todos">
					Usuarios
				</a>
			</td>
			<td>
				<?php
				print($filaDeCuentaUsuarios['cuantos'])
				?>
			</td>
		</tr>
		<tr>
			<td>
				<a title="lib/php/buscausuarios.php?sexo=mujer">
					Mujeres
				</a>
			</td>
			<td>
				<?php
				$filaDeCuentaUsuariosPorSexo = $resultadoDeCuentaUsuariosPorSexo->fetch_assoc();
				print($filaDeCuentaUsuariosPorSexo['cuantos']);
				?>
			</td>
		</tr>
		<tr>
			<td>
				<a title="lib/php/buscausuarios.php?sexo=hombre">
					Hombres
				</a>
			</td>
			<td>
				<?php
				$filaDeCuentaUsuariosPorSexo = $resultadoDeCuentaUsuariosPorSexo->fetch_assoc();
				print($filaDeCuentaUsuariosPorSexo['cuantos']);
				?>
			</td>
		</tr>
		<tr>
			<td>
				<a title="lib/php/buscausuarios.php?busca=tutores">                    
                    Tutores
				</a>
			</td>
			<td>
				<?php
				$filaDeCuentaTutores = $resultadoDeCuentaTutores->fetch_assoc();
				print($filaDeCuentaTutores['cuantos']);
				?>  
			</td>
		</tr>
		<tr>
			<td>
				<a title="lib/php/buscausuarios.php?busca=tutorados">                    
                    Tutorados
				</a>
			</td>
			<td>
				<?php
				$filaDeCuentaTutorados = $resultadoDeCuentaTutorados->fetch_assoc();
				print($filaDeCuentaTutorados['cuantos']);
				?>  
			</td>
		</tr>
	</table>
</center>