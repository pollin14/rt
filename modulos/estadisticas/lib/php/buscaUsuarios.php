<?php
include '../../../../configuracion.php';
header('Content-Type: text/html; charset=UTF-8');

$db = dameConexion();

if (isset($_GET['sexo'])) {
	$buscaUsuarios = 'select idUsuario, nick, nombre from Usuarios';
	switch ($_GET['sexo']) {
		case 'mujer':
			$titulo = "Mujeres";
			$buscaUsuarios.= ' where sexo =1';
			break;
		case 'hombre':
			$titulo = "Hombres";
			$buscaUsuarios.= ' where sexo =2';
			break;
		case 'maquina':
			$buscaUsuarios.= ' where sexo =3';
			break;
		case 'todos':
			$titulo = "Todos los Usuarios";
			$buscaUsuarios.= ' where sexo !=3';
			break;
	}
	$buscaUsuarios.=" order by nick;";
}

if (isset($_GET['busca'])) {
	switch ($_GET['busca']) {
		case 'tutores':
			$titulo = "Tutores";
			$buscaUsuarios = 'select 
                                        Usuarios.idUsuario, Usuarios.nick 
                                        from 
                                        Temas, Usuarios 
                                        where 
                                        Usuarios.idUsuario = Temas.idUsuario
                                        group by
                                        Usuarios.idUsuario
                                        order by
                                        Usuarios.nick;';
			break;
		case 'tutorados':
			$titulo = "Tutorados";
			$buscaUsuarios = 'select 
                                        Usuarios.idUsuario, Usuarios.nick 
                                        from 
                                        Tutorias, Usuarios 
                                        where 
                                        Usuarios.idUsuario = Tutorias.estudiante
                                        group by
                                        Usuarios.idUsuario
                                        order by
                                        Usuarios.nick;';
			break;
		case 'entidad':
			$titulo = ucfirst($_GET['entidad']);
			$buscaUsuarios = sprintf('select 
                                        * 
                                        from 
                                        Usuarios, Entidades 
                                        where 
                                        Entidades.idEntidad = Usuarios.idEntidad 
                                        and 
                                        Entidades.nombre = "%s" 
                                        order by 
                                        Usuarios.nick;', $_GET['entidad']);
			break;
	}
}
$resultadoDeBuscaUsuarios = $db->query($buscaUsuarios);
?>
<center>
	<table border="1">
		<thead>
			<tr><td colspan="2"> <?php echo $titulo ?></td></tr>
		</thead>
		<tbody>
            <tr>
                <td>
                    ID
                </td>
                <td>
                    Nick
                </td>                    
            </tr>       
<?php
while ($resultadoDeBuscaUsuarios && $filaDeBuscaUsuarios = $resultadoDeBuscaUsuarios->fetch_assoc()) {
	echo '<tr>';
	echo '<td>';
	echo $filaDeBuscaUsuarios['idUsuario'];
	echo '</td>';
	echo '<td>';
	echo $filaDeBuscaUsuarios['nick'];
	echo '</td>';
	echo '</tr>';
}
?>
		</tbody>
	</table>
</center>
