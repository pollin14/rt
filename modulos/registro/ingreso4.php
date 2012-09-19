<?php
session_start();
include '../../configuracion.php';
header('Content-Type: text/html; charset=UTF-8');

function asigna($dato) {
    if (isset($_POST[$dato])) {
        $_SESSION[$dato] = $_POST[$dato];
    } else {
        $_SESSION[$dato] = "null";
    }
}

asigna('idEntidad');
asigna('idNodo');
asigna('idNivel');
asigna('idModalidad');
//var_dump($_SESSION);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template1.dwt" codeOutsideHTMLIsLocked="false" -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="lib/js/jquery.js"></script>
        <script type="text/javascript" src="lib/js/cct.js"></script>
        <title>Documento sin t&iacute;tulo</title>
        <link rel="stylesheet" type="text/css" href="lib/css/cct.css" />
        <link rel="stylesheet" type="text/css" href="../../lib/css/esviap.css" />
        <!-- InstanceParam name="id" type="text" value="center" -->
    </head>

    <body>
        <?php include "../../lib/php/encabezado.php"; ?>
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
                <form action="ingreso5.php" method="POST" name="form" id="form" onsubmit="return validaForm()">
                    <p>Ingresa tus datos  laborales (Clave de Centro de Trabajo y el turno):</p>
                    <table align="center" >
                        <tr>
                            <td colspan="2" align="center"><h4>Ingresa tus datos</h4></td>
                        </tr>
                        <tr valign="baseline">
                            <td nowrap="nowrap" align="right">CCT:</td>
                            <td><input name="cct" type="text" id="cct" value="" size="10" maxlength="10" /></td>
                        </tr>
                        <tr valign="baseline">
                            <td nowrap="nowrap" align="right">Turno:</td>
                            <td>
                                <select name="idTurno" id="turno">
                                    <option value='1'>Matutino</option>
                                    <option value='2'>Vespertino</option>
                                    <option value='3'>Nocturno</option>
                                    <option value='4'>Discontinuo</option>
                                    <option value='5'>Mixto</option>              
                                </select>
                            </td>
                        </tr>

                        <tr valign="baseline">
                            <td nowrap="nowrap" align="right">&nbsp;</td>
                            <td><input type="submit" value="Continuar" /></td>
                        </tr>
                    </table>
                </form>
                <input type="hidden" id="mail" value="<?php echo $_SESSION['email']; ?>"></input>
                <p id="preview">No cuento con CCT</p>
                <div id="mascara"> 
                    <select>
                        <?php
                        $db = dameConexion();

                        $buscaEntidades = 'SELECT * FROM entidades;';
                        $resultadoDeEntidades = $db->query($buscaEntidades);
                        while ($resultadoDeEntidades && $filaDeEntidades = $resultadoDeEntidades->fetch_assoc()) {
                            echo '<option value="' . $filaDeEntidades['idEntidad'] . '">';
                            echo $filaDeEntidades['nombre'];
                            echo '</option>';
                        }
                        ?>
                    </select>
                    <p>Entidad:
                        <input type="text" id="entidad">

                        </input></p>
                    <p>Localidad:
                        <input type="text" id="localidad">

                        </input>
                    </p>
                    <p>Municipio:
                        <input type="text" id="Municipio">

                        </input>
                    </p>
                    <p>Nombre de la escuela:
                        <input type="text" id="escuela">

                        </input>
                    </p>
                    <p id="cerrar">Ok</p>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </div>
            <div class="anuncio" style="background:#E3E8EE; height:3px; visibility:hidden" >
                continuar <a href="ingreso_1.php">
                    <img src="../img/next.png" width="63" height="57" alt="alta de usuario" align="absmiddle"/>
                </a>  </div>
        </div>
        <!-- InstanceEndEditable -->
        <?php include "../../lib/php/pieDePagina.php" ?>        
    </body>
</html>