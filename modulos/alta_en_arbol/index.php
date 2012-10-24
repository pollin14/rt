<?php require_once('../../Connections/esviap_conn.php'); ?>
<?php 
//include('conexion.php');
session_start();
	if (!isset($_GET["uid"])) 
	{
if (!isset($_SESSION['cve'])){
		echo "<h2>Se requieren par&aacute;metros...<hr /></h2>";
		exit(1);
}
else {$cve=$_SESSION['cve'];}
	}
	else {$cve=$_GET["uid"];
}
//else
//{

$_SESSION['modulo']="tc";
$_SESSION['cve']=$cve;
$admin_kw=false; 
if ($cve=="c9f0f895fb98ab9159f51fd0297e236d" || $cve=="456"){
$admin_kw=true; 
}
if (isset($_GET["kw"])) {
	$_SESSION['modulo']="kw";
}
$qry="select idUsuario as idu,nombre as firstname,apellidos as lastname from usuarios where idUsuario='".$cve."'";
//$qry="select id as idu,firstname,lastname from mdl_user where id='".$cve."'";
//echo $qry;
$re=mysql_query($qry);
if (mysql_num_rows($re)<1) {
	echo "<h3>Usuario inv&aacute;lido</h3>";
	exit(1);
}

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!---meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /--->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/esviap.css" >
<title>ESVIAP, alta de temas de cat&aacute;logo</title>
<style type="text/css">
/*body {
	background-color: #FF9;
}*/
tr {color:#FFFFFF;}
tr.esp {background:#00958F;}
tr.ciencias {background:#F39800;}
tr.mat {background:#BCDDAA; color:#006600;}
tr.hdr { background: #0099CC;}

</style>
</head>
<script>
//hacer que funcione con diferentes navegadores
function requerir(){
	try{
	req=new XMLHttpRequest();
	}catch(err1){
		try{
		req=new ActiveXObject("Microsoft.XMLHTTP");
		}catch(err2){
			try{
			req=new ActiveXObject("Msxml2.XMLHTTP");
			}catch(err3){
			req= false;
			}
		}
	}
return req;
}

var peticion=requerir();

function llamarAjaxGETud(addud){
	var aleatorio=parseInt(Math.random()*999999999);
	gr=document.getElementById("grados").value;
	as=document.getElementById("as").value;
	if (gr==""){alert("Por favor elige el periodo escolar"); return;}
	if (as==""){alert("Por favor elige asignatura"); return;}
	if (gr==-1 || as==-1){return;} 
	
	if (addud){
		udn=document.getElementById("udn").value;
		if (udn==""){
			alert("por favor, captura el nombre de la UD que deseas dar de alta");
			udn=document.getElementById("udn").focus();
			return;
		}
		var url="ud.php?gr="+gr+"&as="+as+"&udn="+udn+"&r="+aleatorio;
	}
	else {var url="ud.php?gr="+gr+"&as="+as+"&r="+aleatorio;}
	peticion.open("GET",url,true);
	peticion.onreadystatechange =respuestaAjaxUD;
	peticion.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	peticion.send(null);
	
	switch(as){
	  case "1":
		document.getElementById("lblestandar").innerHTML="Seleccione el componente";
		break;
	  case "2":
		document.getElementById('lblestandar').innerHTML='Seleccione el eje';
		break;
	  case "3":
		document.getElementById('lblestandar').innerHTML='Seleccione la categoría';
		break;
	  default:
		document.getElementById('lblestandar').innerHTML='ABC';
	}
}

function llamarAjaxGETude(addude){
	var aleatorio=parseInt(Math.random()*999999999);
	ud=document.getElementById("ud").value;
	gr=document.getElementById("grados").value;
	as=document.getElementById("as").value;
	if (addude){
		uden=document.getElementById("uden").value;
		if (uden==""){
			alert("por favor, captura el nombre de la UDE que deseas dar de alta");
			uden=document.getElementById("uden").focus();
			return;
		}
		var   url="ude.php?gr="+gr+"&as="+as+"&ud="+ud+"&uden="+uden+"&r="+aleatorio;
	}
	else {var url="ude.php?gr="+gr+"&as="+as+"&ud="+ud+"&r="+aleatorio;}
	//alert(url);
	peticion.open("GET",url,true);
	peticion.onreadystatechange =respuestaAjaxUDE;
	peticion.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	peticion.send(null);
}

function llamarAjaxGET_temas(){
  var tc_name=document.getElementById("tc_name").value;
  if (tc_name=="-1"){
	alert("por favor, selecciona el nombre que deseas dar de alta");
	document.getElementById("tc_name").focus();
	return;
  }
  if (document.getElementById('ude').value==""){
	alert("por favor, selecciona el nombre de la unidad diagnóstica específica que deseas dar de alta");
	document.getElementById('ude').focus();
	return;
  }
  var aleatorio=parseInt(Math.random()*999999999);
  var valor=document.getElementById("idu").value;
  var url="elegidos.php?idu="+valor;
  var selObj = document.getElementById('ude');
  var i;
	for (i=0; i<selObj.options.length; i++) {
	  if (selObj.options[i].selected) {
		url=url+"&ude="+ selObj.options[i].value;
	  }
	}
  url=url+"&tcn="+tc_name+"&r="+aleatorio;
  
  peticion.open("GET",url,true);
  peticion.onreadystatechange =respuestaAjaxTC;
  peticion.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  peticion.send(null);
}

function llamarAjaxGET_deltema(idtc,ide){
	var aleatorio=parseInt(Math.random()*999999999);
	var ude=document.getElementById("ude").value;
	var idu=document.getElementById("idu").value;
	var url="deltema.php?ude="+ude+"&idu="+idu+"&idtc="+idtc+"&ide="+ide+"&r="+aleatorio;
	
	peticion.open("GET",url,true);
	peticion.onreadystatechange =respuestaAjaxTC;
	peticion.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	peticion.send(null);
}

function llamarAjaxGET_chtema(oldname,newname){
	if (newname==null ) {return;}
	if (newname=="" ) {alert ("el nombre no puede ser vacio"); return;}
	var aleatorio=parseInt(Math.random()*999999999);
	var idu=document.getElementById("idu").value;
	var url="chtema.php?idu="+idu+"&on="+oldname+"&nn="+newname+"&r="+aleatorio;
	peticion.open("GET",url,true);
	peticion.onreadystatechange =respuestaAjaxTC;
	peticion.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	//alert('before');
	peticion.send(null);
}

function llamarAjaxGET_nocatalogados(){
	var tc_name=document.getElementById("tc_name").value;
	if (tc_name==""){
	alert("por favor, captura el nombre que deseas dar de alta.");
	return;
	}
	var aleatorio=parseInt(Math.random()*999999999);
	var valor=document.getElementById("idu").value;
	var url="elegidos.php?idu="+valor;
		url=url+"&ude=0";
	url=url+"&tcn="+tc_name+"&r="+aleatorio;
	//alert(url);
	peticion.open("GET",url,true);
	peticion.onreadystatechange =respuestaAjaxTC;
	peticion.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	peticion.send(null);
}

function respuestaAjaxUD(){
	if(peticion.readyState==4){
		if(peticion.status==200){
		//alert(peticion.responseText);
		document.getElementById("ud_div").innerHTML=peticion.responseText;
		}else{
		alert("ha ocurrido un error"+peticion.statusText);
		}
	}
}
function respuestaAjaxUDE(){
	if(peticion.readyState==4){
		if(peticion.status==200){
		//alert(peticion.responseText);
		document.getElementById("ude_div").innerHTML=peticion.responseText;
		}else{
		alert("ha ocurrido un error"+peticion.statusText);
		}
	}
}
function respuestaAjaxTC(){
	if(peticion.readyState==4){
		if(peticion.status==200){
		//alert(peticion.responseText);
		document.getElementById("tc").innerHTML=peticion.responseText;
		}else{
		alert("ha ocurrido un error"+peticion.statusText);
		}
	}
}
function respuestaAjaxdeltema(){
	if(peticion.readyState==4){
		if(peticion.status==200){
		//alert(peticion.responseText);
		document.getElementById("tc").innerHTML=peticion.responseText;
		}else{
		alert("ha ocurrido un error"+peticion.statusText);
		}
	}
}

</script>

<head>
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
	<?php include "../../lib/php/encabezado.php"?>
	<?php include "../../lib/php/menu.php"?>
<table width="100%" border="0" >
  <tr>
    <th width="58%" scope="col">
    <h3 align="center">M&oacute;dulo: 
	<?php 
	if ($_SESSION['modulo']=="tc") 
	{echo "registro de temas de cat&aacute;logo";} 
	else 
	{echo "registro de KeyWords";} ?>
    </h3></th>
  </tr>
</table>
<h2 align="center">
  <?php 

while($f=mysql_fetch_array($re)){
  $usr=$f['idu'];
  $uname=$f['firstname']." ";
  //.$f['lastname'];
  $_SESSION['uname']=$uname;
  $_SESSION['idu']=$usr;
  }


if ($_SESSION['modulo']=="tc") 
  {$lbl_btn= "cambiar a KeyWords";
  $url=$_SERVER['PHP_SELF']. "?uid=".$cve."&kw=HSLFD4R43";} 
else 
  {$lbl_btn=  "cambiar a temas de cat&aacute;logo";
  $url=$_SERVER['PHP_SELF']. "?uid=".$cve;}
?>
</h2>
<table width="100%" border="0">
  <tr>
    <th width="73%" height="26" align="left" scope="col"><h3>Bienvenido(a) <?php echo $uname; ?></h3></th>
    <th width="27%" scope="col">
    	<?php //if ($admin_kw){?>
		<!--form id="form2" name="form2" method="post" action="<?php //echo $url; ?>">
          <input type="submit" name="btn_chg" id="btn_chg" value="<?php  //echo $lbl_btn;?>" />
        </form-->
		
		<?php //}?>
  </tr>
</table>
<hr />
<form name="form1" id="form1">
<div id="hdr" > 
  <h4>
    <label>
    <?php 
	if ($_SESSION['modulo']=="tc") 
	{echo "Para el tema de cat&aacute;logo";} 
	else 
	{echo "Para el KeyWord";} 
	?>
    
    <select name="tc_name" id="tc_name">
    <option value="-1">---</option>
	  <?php
      $re=mysql_query("SELECT * FROM temas WHERE idUsuario = $usr");
      if (!$re) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
      }
	  $totalRows_tc=0;
      while($f=mysql_fetch_array($re)){
      $value=$f['idTema'];
      $texto=$f['nombre'];
      echo'<option value="'.$value.'">'.$texto.'</option>';
	  $totalRows_tc++;
      }
      ?>
    </select>
    </label>
    <!---a href="javascript:alert(&quot;Seleccione el t&iacute;tulo de la experiencia de aprendizaje, si no cuenta con temas de cat&aacute;logo cargados, empiece creando su grupo de los mismos&quot;);"><img src="/esviap/alta_en_arbol/img/hlp.bmp" title="ayuda" border="0" /></a---> 
    <a href="javascript:alert(&quot;Seleccione el t&iacute;tulo de la experiencia de aprendizaje, si no cuenta con temas de cat&aacute;logo cargados, empiece creando su grupo de los mismos&quot;);"><img src="img/hlp.bmp" title="ayuda" border="0" /></a> 
    (<?php echo $totalRows_tc; ?>) temas de cat&aacute;logo, <a href="tcabm.php"><img src="img/edit.jpg" alt="Administrar mis temas de cat&aacute;logo" width="24" height="24" border="0" /></a></h4>
  <h4>Seleccione asignatura, periodo y est&aacute;ndar:
    <!---a href="http://dof.gob.mx/nota_detalle.php?codigo=5205518&amp;fecha=19/08/2011" target="_blank"><img src="/esviap/alta_en_arbol/img/hlp.bmp" alt="link al acuerdo 592" border="0" /></a---><br />
  </h4>
</div>

<table width="100%">
    <tr class="hdr">
      <th width="14%">Seleccione asignatura</th>
      <th width="38%"><p align="center">Seleccione periodo escolar<br />
        (seg&uacute;n Plan de Estudios 2011)</p>
      </th>
      <th width="48%">
      <label id="lblestandar"></label>
      </th>
    </tr>
    <tr>
      <td ><div id="asig" style="width:100px; float:left">
<select name="as" id="as" onChange="llamarAjaxGETud()">
  <option value="-1">---</option>
  <?php
  $re=mysql_query("select * from asignaturas");
  while($f=mysql_fetch_array($re)){
  echo'<option value="'.$f['idAsignatura'].'">'.$f['nombre'].'</option>';
  }
  ?>
</select>
</div></td>
      <td ><div id="grado" style="width:250px; float:left">
<select name="grados" id="grados" onChange="llamarAjaxGETud()">
  <option value="-1">---</option>
  <?php
  $re=mysql_query("select * from periodos");
  if (!$re) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  while($f=mysql_fetch_array($re)){
  $Id_Grado=$f['idPeriodo'];
  $nivel=$f['nombre'];
  echo'<option value="'.$Id_Grado.'">'.$nivel.'</option>';
  }
  ?>
</select>
</div></td>
      <td ><div id="ud_div" style="width:530px; float:left">
<select  name="ud" disabled="disabled" id="ud"> 
<option value="-1">---</option>
</select>
</div></td>
    </tr>
  </table>




<h4><input name="idu" type="hidden" id="idu" value="<?php echo $usr;  ?>" />
  <br />
  Seleccione est&aacute;ndar: <a href="javascript:alert(&quot;Seleccione un est&aacute;ndard&quot;);"><img src="img/hlp.bmp" alt="ayuda" border="0" /></a></h4>
<div id="ude_div" style="width:250px">
  <select name="ude" disabled="disabled" id="ude">
   <option value="-1">---</option>
  </select>
<!--/p-->
</div>

<br />
<div id="tc" style="width:100%;height:250px;overflow:auto;">
<?php
$idu=$usr;
include ("listado_tc.php")

?>
</div>
</form>
<?php include "../../lib/php/pieDePagina.php"?>
</body>
</html>
<?php
//}
?>