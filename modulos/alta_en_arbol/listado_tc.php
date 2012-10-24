<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php
//header("Content-Type: text/html;charset=utf-8");

$qres1="SELECT mdl_user.firstname, mdl_user.lastname, dbo_grados.Grado, dbo_grados.Nivel, dbo_asignaturas.Asignatura, ud.Unidad_Diagnostica, dbo_reactivos.Descrip_Mapeo, mdl_user.id, dbo_reactivos.id_reactivo, user_tema.temacatalogo, user_tema.idTema, user_tema.user
FROM ((((user_tema INNER JOIN mdl_user ON user_tema.user=mdl_user.id) INNER JOIN dbo_reactivos ON user_tema.id_reactivo=dbo_reactivos.id_reactivo) INNER JOIN dbo_grados ON dbo_reactivos.Id_Grado=dbo_grados.Id_Grado) INNER JOIN dbo_asignaturas ON dbo_reactivos.Id_Asignatura=dbo_asignaturas.Id_Asignatura) INNER JOIN ud ON dbo_reactivos.Id_UD=ud.Id
WHERE (((user_tema.user)=$idu)) order by user_tema.temacatalogo";

$qres2="SELECT mdl_user.firstname, mdl_user.lastname, dbo_grados.Grado, dbo_grados.Nivel, dbo_asignaturas.Asignatura, ud.Unidad_Diagnostica, dbo_reactivos.Descrip_Mapeo, mdl_user.id, dbo_reactivos.id_reactivo, user_tema.temacatalogo, user_tema.idTema, user_tema.user
FROM ((((user_tema INNER JOIN mdl_user ON user_tema.user=mdl_user.id) INNER JOIN dbo_reactivos ON user_tema.id_reactivo=dbo_reactivos.id_reactivo) INNER JOIN dbo_grados ON dbo_reactivos.Id_Grado=dbo_grados.Id_Grado) INNER JOIN dbo_asignaturas ON dbo_reactivos.Id_Asignatura=dbo_asignaturas.Id_Asignatura) INNER JOIN ud ON dbo_reactivos.Id_UD=ud.Id  order by user_tema.temacatalogo";


//$qres3="SELECT mdl_user.firstname, mdl_user.lastname, dbo_grados.Grado, dbo_grados.Nivel, dbo_asignaturas.Asignatura, ud.Unidad_Diagnostica, dbo_reactivos.Descrip_Mapeo, mdl_user.id, dbo_reactivos.id_reactivo, user_tema.temacatalogo, user_tema.id, user_tema.user
//FROM ((((user_tema INNER JOIN mdl_user ON user_tema.user=mdl_user.id) INNER JOIN dbo_reactivos ON user_tema.id_reactivo=dbo_reactivos.id_reactivo) INNER JOIN dbo_grados ON dbo_reactivos.Id_Grado=dbo_grados.Id_Grado) INNER JOIN dbo_asignaturas ON dbo_reactivos.Id_Asignatura=dbo_asignaturas.Id_Asignatura) INNER JOIN ud ON dbo_reactivos.Id_UD=ud.Id  WHERE (temacatalogo like '%maten%') order by user_tema.temacatalogo";


	if ($_SESSION['modulo']=="tc") 
	{$table="EstandaresDeTema";} 
	else 
	{$table="user_kw";}


/*
$qres3="SELECT usuarios.nombre, usuarios.apellidos, periodos.Per_name, asignaturas.Asig_name, ComponenteEjeCategoria.nombre, estandares.Estandar, temas.temacatalogo, $table.idUsuario, $table.user
FROM (((($table INNER JOIN usuarios ON $table.user = usuarios.idUsuario) INNER JOIN estandares ON $table.idTema = estandares.idEstandar) INNER JOIN periodos ON estandares.Id_per = periodos.Id) INNER JOIN asignaturas ON estandares.Id_asig = asignaturas.id) INNER JOIN ComponenteEjeCategoria ON estandares.idComponenteEjeCategoria = ComponenteEjeCategoria.idComponenteEjeCategoria  INNER JOIN temas ON temas.idTema = EstandaresDeTema.idTema 
WHERE ((($table.user)=$idu))
ORDER BY temas.nombre;";
*/
$qres3="
select 
    u.nombre                                        as nombre, 
	u.apellidos,
    p.nombre                                        as periodo, 
    a.nombre                                        as asignatura, 
    c.nombre                                        as cec, 
    e.descripcion                                   as estandar,
    t.nombre                                        as tema,
	u.nick,t.idTema,e.idEstandar
    
    from
    
    usuarios                    as u,
    periodos                    as p,
    asignaturas                 as a,
    componenteejecategoria      as c,
    temas                       as t,
    estandares                  as e,
    estandaresdetema            as es
    
    where 
    
    p.idPeriodo = e.idPeriodo
    and
    a.idAsignatura = e.idAsignatura
    and
    c.idComponenteejecategoria = e.idComponenteEjeCategoria
    and
    u.idUsuario = t.idusuario 
    and
    e.idEstandar = es.idEstandar
    and
    t.idTema = es.idTema
    and
    t.idUsuario = $idu;

";
$qres=$qres3;
//echo $qres;
$re=mysql_query($qres);

//$qcount_tc="select idTema from $table where $table.user=$idu group by id_tc";
$qcount_tc="select idTema from temas where temas.idUsuario=$idu";
$rs_count_tc=mysql_query($qcount_tc);
?>
<h3 align="center">M&oacute;dulo: 
    <?php 
	if ($_SESSION['modulo']=="tc") 
	{echo "registro de temas de cat&aacute;logo";} 
	else 
	{echo "registro de KeyWords";} ?> (<?php echo mysql_num_rows($re); ?>) est&aacute;ndares y (<?php echo mysql_num_rows($rs_count_tc); ?>) temas de cat&aacute;logo</h3>
<table width="98%" border="0">
  <tr class="hdr">
    <th>Nombre del tutor</th>
    <th>Periodo</th>
    <th>Asignatura</th>
    <th>Componente/Eje/Categor&iacute;a</th>
    <th>Est&aacute;ndar</th>
    <th>
     <?php 
	if ($_SESSION['modulo']=="tc") 
	{echo "Tema cat&aacute;logo";} 
	else 
	{echo "KeyWord";} ?>

    </th>
    <th colspan="2">Acciones</th>
  </tr>
<?php
while($f=mysql_fetch_array($re)){
?>
  <tr class="
  <?php
  $subcadena=substr($f[3],0,3);
  switch ($subcadena) {
    case "Esp":
        echo "esp";
        break;
    case "Cie":
        echo "ciencias";
        break;
    case "Mat":
        echo "mat";
        break;
//	default: echo $f[3];	}
	default: echo "hdr";	}
  ?>">
    <td><?php echo htmlentities($f['nombre']." ".$f['apellidos'],ENT_QUOTES,"UTF-8") ?></td>
    <td><?php echo htmlentities($f[2],ENT_QUOTES,"UTF-8") ?></td>
    <td><?php echo htmlentities($f[3],ENT_QUOTES,"UTF-8") ?></td>
    <td><?php echo htmlentities($f[4],ENT_QUOTES,"UTF-8") ?></td>
    <td><?php echo htmlentities($f[5],ENT_QUOTES,"UTF-8") ?></td>
    <td><?php echo htmlentities($f[6],ENT_QUOTES,"UTF-8") ?></td>
    <td><button type="button" onclick="javascript:if (confirm('&iquest;eliminar <?php echo htmlentities($f[6]); ?>?'))llamarAjaxGET_deltema(<?php echo "$f[8],$f[9]"; ?>)">eliminar</button></td>

  </tr>

<?php
  } 
?>
  
</table>
