<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 

header('Content-Type: text/html; charset=UTF-8');
?>
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template1.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso</title>
<link rel="stylesheet" type="text/css" href="../../lib/css/esviap.css" />
<!-- InstanceParam name="id" type="text" value="center" -->
</head>

<body>
<?php include '../../lib/php/encabezado.php'?>
<!-- InstanceBeginEditable name="Region1" -->
<script language="javascript">
function validaForm() { 
errors ='';
if (document.form.Nombre.value=="") 
{errors += 'Nombre es obligatorio,\n '; }

if (document.form.Apellidos.value=="") 
{errors += 'Apellidos es obligatorio,\n ';  }

thisOne = -1;
for (i=0; i<document.form.Sexo.length; i++) {
  if (document.form.Sexo[i].checked) {
	thisOne = i;
	whichOne = (thisOne+1);
	}
  }
if (thisOne == -1) {
errors += 'Sexo es obligatorio '; }

 if (errors==""){return true; }
  else {
	 errors = "Por favor corregir los siguientes errores:\n"+ errors;
	 alert (errors);
	 return false;
	 }
}

</script>
<div id="center">
  <div class="anuncio" >Alta de usuario</div>
  <div class="anuncio" style=" width:400px; height:246px; padding-top:100px; text-align:justify">
    <!---form action="ingreso2.php" method="get" name="form" id="form" onsubmit="MM_validateForm('Sexo','','R','Apellidos','','R','Nombre','','R');return document.MM_returnValue"--->
    <form action="ingreso2.php" method="POST" name="form" id="form" onsubmit="return validaForm();">
      <p>Captura tu nombre, apellidos y tu sexo:      </p>
      <table align="center" >
        <tr>
          <td colspan="2" align="center"><h4>Ingresa tus datos</h4></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Nombre:</td>
          <td><input name="nombre" type="text" id="Nombre" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Apellidos:</td>
          <td><input name="apellidos" type="text" id="Apellidos" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td height="29" align="right" nowrap="nowrap">Sexo:</td>
          <td><label>
				  <input type="radio" name="sexo" value="hombre" id="Sexo" checked/>
            Hombre</label>
            <label>
              <input type="radio" name="sexo" value="mujer" id="Sexo" />
              Mujer</label></td>
        </tr>
        <div class="nivel">        </div>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Continuar" /></td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p>
<p>&nbsp;</p>
  </div>
  <div class="anuncio" style="background:#E3E8EE; height:3px; visibility:hidden" >
      continuar 
      <a href="ingreso2.php">
          <img src="../img/next.png" width="63" height="57" alt="alta de usuario" align="absmiddle"/>
      </a></div>
</div>
<!-- InstanceEndEditable -->
<?php include "../../lib/php/pieDePagina.php"?>

</body>
<!-- InstanceEnd --></html>
