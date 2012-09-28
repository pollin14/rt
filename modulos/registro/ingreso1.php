<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Alta de Usuarios</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<link rel="StyleSheet" href="../../lib/css/style.css" type="text/css"/>
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
	</head>

	<body>

		<div id="wrapper">

			<div id="header">

			</div>

			<div id="content">			
				<form action="ingreso2.php" method="POST" name="form" id="form" onsubmit="return validaForm();">
					<p>Captura tu nombre, apellidos y tu sexo:</p>
					<table>
						<tr>
							<td colspan="2"><h4>Ingresa tus datos</h4></td>
						</tr>
						<tr>
							<td>Nombre:</td>
							<td><input name="nombre" type="text" id="Nombre" value="" size="32" /></td>
						</tr>
						<tr>
							<td>Apellidos:</td>
							<td><input name="apellidos" type="text" id="Apellidos" value="" size="32" /></td>
						</tr>
						<tr>
							<td>Sexo:</td>
							<td>
								<input type="radio" name="sexo" value="hombre" id="hombre" checked/>
								<label for="hombre">Hombre</label>

								<input type="radio" name="sexo" value="mujer" id="mujer" />
								<label>Mujer</label></td>
						</tr>
						<tr>
							<td></td>
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
