<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

function asigna($dato) {
	if (isset($_POST[$dato])) {
		$_SESSION[$dato] = $_POST[$dato];
	} else {
		$_SESSION[$dato] = "";
	}
}

asigna('cct');
asigna('idTurno');

//var_dump($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Alta de Usuarios</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<link rel="StyleSheet" href="../../lib/css/style.css" type="text/css"/>
			<script type="text/javascript" src="lib/js/jquery.js"></script>
			<script language="javascript">
				function validaForm() { 
					errors ='';
					if (document.form.nombre.value=="") 
					{errors += 'Nombre es obligatorio,\n '; }

					if (document.form.apellidos.value=="") 
					{errors += 'Apellidos es obligatorio,\n ';  }
					
					if (errors==""){return true; }
					else {
						errors = "Por favor corregir los siguientes errores:\n"+ errors;
						alert (errors);
						return false;
					}
				}

			</script>
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
	</head>

	<body>

		<div id="wrapper">

			<div id="header">

			</div>

			<div id="content">			
				<form action="alta.php" method="POST" name="form" id="form" onsubmit="return validaForm()">
					<p>Por último, define un  nombre de usuario y una contraseña para tu ingreso seguro a la plataforma:</p>
					<table align="center" >
						<tr valign="baseline">
							<td nowrap="nowrap" align="right">Usuario:</td>
							<td><input name="nick" type="text" id="IdUser" value="" size="32" /></td>
						</tr>
						<tr valign="baseline">
							<td nowrap="nowrap" align="right">Contraseñaa:</td>
							<td><input type="password" name="contraseña" id="C" size="32" value=""/></td>
						</tr>
						<tr valign="baseline">
							<td nowrap="nowrap" align="right">Confirmar contraseña:</td>
							<td><input name="password2" type="password" id="password2" value="" size="32"/></td>
						</tr>

						<tr valign="baseline">
							<td nowrap="nowrap" align="right"></td>
							<td><input type="submit" value="Continuar" /></td>
						</tr>
					</table>
				</form>
			</div>

			<div id="footer">
				<div id="footer-valid">
					<?php include '../../lib/php/direccion.php' ?>
				</div>
			</div>

		</div>

	</body>
</html>
