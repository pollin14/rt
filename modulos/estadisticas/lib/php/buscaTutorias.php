<?php
require '../../../../configuracion.php';
require '../../lib/Estadisticas.php';

$db = dameConexion();
$e = new Estadisticas($db);

$sinMensajes = 0 + $e->cuantasTutoriasHay() - $e->cuantasTutoriasFinalizadasHay()+
	$e->cuantasTutoriasEnDemostracionHay()+
	$e->cuantasTutoriasBuscandoSinodalesHay()+
	$e->cuantasTutoriasActivasHay();

$query = 'select 
            Temas.nombre as tema, Usuarios.nombre as estudiante, Tutorias.idTutoria , Tutores.Tutor, Etapas.max
            from 
            Tutorias, Usuarios, Temas , ((select 
            Tutorias.idTutoria, Usuarios.nombre as Tutor, Temas.idTema
            from 
            Tutorias, Usuarios, Temas 
            where 
            Usuarios.idUsuario = Temas.idUsuario 
            and 
            Tutorias.idTema=Temas.idTema)as Tutores)
            , ((select 
            * 
            from ((select 
            idTutoria, max(idEtapa) as max 
            from 
            historial group by idTutoria) as maximo)
            where 
            max =%d)as Etapas)
            where 
            Temas.idTema=Tutorias.idTema 
            and 
            Usuarios.idUsuario= Tutorias.estudiante
            and
            Tutorias.idTutoria= Tutores.idTutoria
            and
            Etapas.idTutoria = Tutorias.idTutoria
            ;';
switch ($_GET['accion']) {
    case 'todos':
        $buscaTutorias = sprintf('select 
                        Temas.nombre as tema, Usuarios.nombre as estudiante, Tutorias.idTutoria , Tutores.Tutor
                        from 
                        Tutorias, Usuarios, Temas , ((select 
                        Tutorias.idTutoria, Usuarios.nombre as Tutor, Temas.idTema
                        from 
                        Tutorias, Usuarios, Temas 
                        where 
                        Usuarios.idUsuario = Temas.idUsuario 
                        and 
                        Tutorias.idTema=Temas.idTema)as Tutores)
                        where 
                        Temas.idTema=Tutorias.idTema 
                        and 
                        Usuarios.idUsuario= Tutorias.estudiante
                        and
                        Tutorias.idTutoria= Tutores.idTutoria
                        order by
                        idTutoria;');
        break;
    case 'terminadas':
        $buscaTutorias = sprintf($query, 6);
        break;
    case 'demostracion':
        $buscaTutorias = sprintf($query,5);
        break;
    case 'espera':
        $buscaTutorias = sprintf($query, 4);
        break;
    case 'tutoria':
        $buscaTutorias = sprintf('select 
                        Temas.nombre as tema, Usuarios.nombre as estudiante, Tutorias.idTutoria , Tutores.Tutor, Etapas.max
                        from 
                        Tutorias, Usuarios, Temas , ((select 
                        Tutorias.idTutoria, Usuarios.nombre as Tutor, Temas.idTema
                        from 
                        Tutorias, Usuarios, Temas 
                        where 
                        Usuarios.idUsuario = Temas.idUsuario 
                        and 
                        Tutorias.idTema=Temas.idTema)as Tutores)
                        , ((select
                        * 
                        from ((
                        select 
                        idTutoria, max(idEtapa) as max 
                        from 
                        historial group by idTutoria) as maximo)
                        where 
                        max <4)as Etapas)
                        where 
                        Temas.idTema=Tutorias.idTema 
                        and 
                        Usuarios.idUsuario= Tutorias.estudiante
                        and
                        Tutorias.idTutoria= Tutores.idTutoria
                        and
                        Etapas.idTutoria = Tutorias.idTutoria
                        order by
                        idTutoria;');
}

$resultadoDeTutorias = $db ->query($buscaTutorias);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../../../../lib/css/esviap.css"/>
        <title></title>
    </head>
    <body>
		<?php

echo '<div id="encabezado">';
echo '<img alt="logo EIMLE" src="../../../../lib/img/eimle.png" 
    style="display:block;margin:auto;">';

?><center>
        <table border="1">
            <tr>
                <td>
                    ID
                </td>
                <td>
                    Tema de Tutoria
                </td>
                <td>
                    Estudiante
                </td>
                <td>
                    Tutor
                </td>
            </tr>
            <?php
            while ($resultadoDeTutorias && $filaDeTutorias = $resultadoDeTutorias -> fetch_assoc()){
                echo '<tr>';
                    echo '<td>';
                        echo $filaDeTutorias['idTutoria'];
                    echo '</td>';
                    echo '<td>';
                        echo $filaDeTutorias['tema'];
                    echo '</td>';
                    echo '<td>';
                        echo $filaDeTutorias['estudiante'];
                    echo '</td>';
                    echo '<td>';
                        echo $filaDeTutorias['Tutor'];
						echo '</td>';
                echo '</tr>';
            }
            ?>
        </table></center>
    </body>
</html>
