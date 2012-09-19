<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

function asigna($dato){
	if(isset($_POST[$dato]))
	{	$_SESSION[$dato]=$_POST[$dato];}
	else
	{	$_SESSION[$dato]="";}
}
asigna('cct');
asigna('idTurno');

//var_dump($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template1.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="../../lib/css/esviap.css" />
<!-- InstanceParam name="id" type="text" value="center" -->
</head>

<?php include "../../lib/php/encabezado.php"?>
<script type="text/javascript" src="lib/js/jquery.js"></script>
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

 $(document).ready(function(){
     
     
     $('#IdUser').focusout(function(){
         var nick = $(this).val()
         $.ajax({
             type: "POST",
             url: "existeusuario.php",
             data: {
                 nick: nick
             },
             dataType: "Text",
             success: function(text){
                 if(text != ""){
                      alert("El nick ya esta en uso, por favor elije otro");
					  $('#IdUser').val("");
                 }
             }
         })
     })
 });



</script>

<div id="center">
  <div class="anuncio" >Alta de usuario</div>
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
  </div>
  <div class="anuncio" style="background:#E3E8EE; height:3px; visibility:hidden" >continuar <a href="ingreso_1.php"><img src="../img/next.png" width="63" height="57" alt="alta de usuario" align="absmiddle"/></a></div>
</div>
<!-- InstanceEndEditable -->
<?php include "../../lib/php/pieDePagina.php"?>

</body>
<!-- InstanceEnd --></html>
