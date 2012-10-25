<!DOCTYPE html>
<html>
    <head>
        <title>Enviar Mensaje Privado</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="control-cache" content="no-cahe"/>
        <script type="text/javascript" src="../../lib/js/funciones.js"></script>
        <script type="text/javascript" src="../../lib/js/jquery.js"></script>
        <script type="text/javascript">
        
        $(document).ready(function(){
            
            var mensaje;
            mensaje = "<p>El tutor <b>" + decodeURIComponent(getUrlVars()['nombreDelTutor']) + "</b>";
            mensaje += " no acepto tutorarte en el tema <b>" + decodeURIComponent(getUrlVars()['nombreDelTema']);
            mensaje += "</b></p><p>Puedes probar con otro tutor. </p>";
            $.ajax({
                type: "POST",
                url: "../../modulos/mensajesPrivados/mensajesPrivados.php",
                typeData: "xml",
                data:{
                    accion: "guarda",
                    de: getUrlVars()['de'],
                    //bug de internet explorer
                    //para: getUrlVars()['para'],
                    para: getUrlVars()['from'],
                    asunto: "Tutoría NO aceptada",
                    mensaje: mensaje
                },
                success: function(){
                	window.setTimeout(
                        function(){
                            window.location = "../../modulos/mensajesPrivados/bandejaDeEntrada.php";
                        }, 2000);
            	}
            });
         }); 
        </script>
    </head>
    <body>
		<center><p style='margin-top:auto;margin-bottom:auto;'> Tutoría Cancelada. Regresando al la bandeja de entrada... </p></center>
    </body>
</html>
