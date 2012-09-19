<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
function asigna($dato){
	if(isset($_POST[$dato]))
	{	$_SESSION[$dato]=$_POST[$dato];}
	else
	{	$_SESSION[$dato]="";}
}
asigna('nombre');
asigna('apellidos');
asigna('sexo');
//var_dump($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template1.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso</title>
<link rel="stylesheet" type="text/css" href="../../lib/css/esviap.css" />
<script type="text/javascript" src="lib/js/jquery.js"></script>

<!-- InstanceParam name="id" type="text" value="center" -->
<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' debes proporcionar un e-mail v<&aacute;lido\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }

function isInteger(s) {
  return (s.toString().search(/^-?[0-9]+$/) == 0);
}

$(document).ready(function(){
    $('[name="telefono"]').change(function(){
        if(!isInteger($(this).val())){
            alert("El numero de telefono no esta bien escrito.")
            $(this).val("");
        }
    })
})

</script>
</head>

<?php include "../../lib/php/encabezado.php"?>
<!-- InstanceBeginEditable name="Region1" -->
<div id="center">
  <div class="anuncio" >Alta de usuario</div>
  <div class="anuncio" style=" width:400px; height:246px; padding-top:100px; text-align:justify">
    <form action="ingreso3.php" 
          method="POST" 
          name="form" 
          id="form" 
          onsubmit="MM_validateForm('email','','RisEmail');return document.MM_returnValue">
      <p>Para poder estar en contacto contigo  ingresa los siguientes datos:</p>
<table align="center" >
        <tr>
          <td colspan="2" align="center"><h4>Ingresa tus datos</h4></td>
        </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Email:</td>
            <td><input name="email" type="text" id="email" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Tel&eacute;fono:</td>
            <td><input type="text" name="telefono" value="" size="32" /></td>
          </tr>

        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" onclick="MM_validateForm('email','','RisEmail');return document.MM_returnValue" value="Continuar" /></td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p>
<p>&nbsp;</p>
  </div>
  <div class="anuncio" style="background:#E3E8EE; height:3px; visibility:hidden" >continuar <a href="ingreso_1.php"><img src="../img/next.png" width="63" height="57" alt="alta de usuario" align="absmiddle"/></a></div>
</div>
<!-- InstanceEndEditable -->
<?php include "../../lib/php/pieDePagina.php"?>

</body>
<!-- InstanceEnd --></html>
