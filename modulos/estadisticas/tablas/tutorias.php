<?php
include '../../../configuracion.php';
require '../lib/Estadisticas.php';
header('Content-Type: text/html; charset=UTF-8');

$db = dameConexion();

$e = new Estadisticas($db);

$sinMensajes = 0 + $e->cuantasTutoriasHay() - ($e->cuantasTutoriasFinalizadasHay()+
	$e->cuantasTutoriasEnDemostracionHay()+
	$e->cuantasTutoriasBuscandoSinodalesHay()+
	$e->cuantasTutoriasActivasHay());
// numero de tutorias
$buscaTutorias = sprintf('select count(*) as cuantos from tutorias;');
$resultadoDeTutorias = $db->query($buscaTutorias);
$filaDeTutorias = $resultadoDeTutorias->fetch_assoc();
// query de etapas
$buscaTutoriasEnEtapaX = 'select
count(*) as cuantos
from
((select
idTutoria, max(idEtapa) as max
from
historial
group by
idTutoria) as t)
where max ';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
</head>
<body>

<table border="1">
<tr>
<td>
<a href="lib/php/buscaTutorias.php?accion=todos">
Tutorías
</a>
</td>
<td>
<?php
                    echo $e->cuantasTutoriasHay();
                    ?>
</td>
</tr>
<tr>
<td>
<a href="lib/php/buscaTutorias.php?accion=terminadas">
Terminadas
</a>
</td>
<td>
<?php
$buscaTutoriasEnEtapa6 = $buscaTutoriasEnEtapaX . '=6;';
$resultado = $db->query($buscaTutoriasEnEtapa6);
$filaResult = $resultado->fetch_assoc();
echo $filaResult['cuantos'];
?>
</td>
</tr>
<tr>
<td>
<a href="lib/php/buscaTutorias.php?accion=demostracion">
En Demostración
</a>
</td>
<td>
<?php
                    $buscaTutoriasEnEtapa5 = $buscaTutoriasEnEtapaX . '=5;';
                    $resultado = $db->query($buscaTutoriasEnEtapa5);
                    $filaResult = $resultado->fetch_assoc();
                    echo $filaResult['cuantos'];
                    ?>
</td>
</tr>
<tr>
<td>
<a href="lib/php/buscaTutorias.php?accion=espera">
En espera de Demostración
</a>
</td>
<td>
<?php
                    $buscaTutoriasEnEtapa4 = $buscaTutoriasEnEtapaX . '=4;';
                    $resultado = $db->query($buscaTutoriasEnEtapa4);
                    $filaResult = $resultado->fetch_assoc();
                    echo $filaResult['cuantos'];
                    ?>
</td>
</tr>
<tr>
<td>
<a href="lib/php/buscaTutorias.php?accion=tutoria">
En tutoría
</a>
</td>
<td>
<?php
                    $buscaTutoriasEnEtapa3 = $buscaTutoriasEnEtapaX . '<4;';
                    $resultado = $db->query($buscaTutoriasEnEtapa3);
                    $filaResult = $resultado->fetch_assoc();
                    echo $filaResult['cuantos'] + $sinMensajes;
                    ?>
</td>
</tr>
</table>
</body>
</html>
<?php
$db->close();
?>