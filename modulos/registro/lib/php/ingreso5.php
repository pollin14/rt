<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

function asigna($dato){
	if(isset($_POST[$dato]))
	{	$_SESSION[$dato]=$_POST[$dato];}
	else
	{	$_SESSION[$dato]="null";}
}
asigna('cct');
asigna('idTurno');

//var_dump($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template1.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="../css/esviap.css" />
<!-- InstanceParam name="id" type="text" value="center" -->
</head>

<body>
<p align="center"><img src="../img/esviap_logo.png" width="523" height="74" alt="logo ESVIAP" /></p>
<div id="up">
</div>
<!-- InstanceBeginEditable name="Region1" -->
<script language="JavaScript">
function validapwd(cad) {
	cad1=document.getElementById("C").value;
//	alert(cad.value);
//	alert(cad1);
	if (cad.value != cad1)
	{alert("las contraseñas deben ser iguales");}
}

function validaForm() { 
errors ='';
if (document.form.IdUser.value=="") 
{errors += 'Nombre de Usuario es obligatorio,\n '; }

if (document.form.C.value=="") 
{errors += 'Contraseña es obligatoria,\n ';  }
else{
	if (document.form.C.value!=document.form.password2.value){errors += 'No coinciden las contrase�as,\n ';}
}

 if (errors==""){return true; }
  else {
	 errors = "Por favor corregir los siguientes errores:\n"+ errors;
	 alert (errors);
	 return false;
	 }
}

</script>

<div id="center">
  <div class="anuncio" style="background:#E3E8EE">Alta de usuario en el Espacio Virtual de Aprendizaje</div>
  <div class="anuncio" style=" width:400px; height:246px; padding-top:100px; text-align:justify">
    <form action="alta.php" method="POST" name="form" id="form" onsubmit="return validaForm()">
      <p>Por &uacute;ltimo, define un  nombre de usuario y una contrase&ntilde;a para tu ingreso seguro a la plataforma:</p>
      <table align="center" >
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Usuario:</td>
            <td><input name="nick" type="text" id="IdUser" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Contrase&ntilde;a:</td>
            <td><input type="password" name="contraseña" id="C" size="32" value=""/></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Confirmar contrase&ntilde;a:</td>
            <td><input name="password2" type="password" id="password2" value="" size="32"/></td>
          </tr>

        <tr valign="baseline">
          <td nowrap="nowrap" align="right"></td>
          <td><input type="submit" value="Continuar" /></td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p>
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <td>Selecciona una imagen por favor</td>
      </tr>
      <tr>
        <td><img src="../img/users/Boy.png" width="35" height="35" /></td>
      </tr>
      <tr>
        <td><img src="../img/users/Lady.png" width="35" height="35" /></td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </div>
  <div class="anuncio" style="background:#E3E8EE; height:3px; visibility:hidden" >continuar <a href="ingreso_1.php"><img src="../img/next.png" width="63" height="57" alt="alta de usuario" align="absmiddle"/></a></div>
</div>
<!-- InstanceEndEditable -->
<div id="footer" >
<p align="center" >Subsecretar&iacute;a de Educaci&oacute;n B&aacute;sica, Viaducto R&iacute;o Piedad 507, 4o piso. Granjas M&eacute;xico, Iztacalco 08400. M&eacute;xico D.F. </p>
</p>
</div>

</body>
<!-- InstanceEnd --></html>
