var idsTemas = 0;
var idTema = 0;
var idTutor = 0;
var idUsuario = 0;
var numeroDePagina = 0;

var asunto = "Solicitud de Tutoría";
var mensaje ="";
var mensaje2 = "";


/* Datos usados para el mensaje */
var nombreDelTutor = "";
var nombreDelTema = "";
var nombreDelAlumno = "";

$(document).ready(function(){
	
    //conseguimos el id del usuario
    idUsuario = dameIdUsuario();
    nombreDelAlumno = dameNombreDeUsuario();
    
    $('#lista2,#lista3,#lista4').hide();
    $('#enviarSolicitud button').prop('disabled',true);
    
    //inicializamos eventos
    $('#enviarSolicitud button').click(function(){
        
        $('#lista2,#lista3,#lista4').hide("slow");
		$('#lista2 select').unbind('change');
		$('#lista3 select').unbind('change');
		$('#lista4 select').unbind('change');
        
        $(this).prop('disabled',true);
		
		mensaje2 += "<h1>Solicitud de tutoria</h1>";
		mensaje2 += "<p> Hola <b>" + nombreDelTutor + "</b></p>";
		mensaje2 += "<p>¿Te gustaría ser tutor de " + nombreDelAlumno + " en el tema: ";
		mensaje2 += "<b>" + nombreDelTema +"</b>?</p>";
		mensaje2 += "<p>Entra a TuRed para aceptarla o rechazarla</p>";
        
		mensaje += "<h1>Solicitud de tutoria</h1>";
		mensaje += "<p> Hola <b>" + nombreDelTutor + "</b></p>";
		mensaje += "<p>¿Te gustaría ser tutor de " + nombreDelAlumno + " en el tema: ";
		mensaje += "<b>" + nombreDelTema +"</b>?</p>";
		mensaje += "<p>Si la respuesta es afirmativa, has click:";
		mensaje += '<a href="';
		mensaje += "../../modulos/solicitudDeTutoria/creaTutoria.php?idTema=";
		mensaje += idTema+"&idTutorado="+idUsuario+'">';
		mensaje += "Aceptar Tutoria</a> </p>";
		mensaje += "<p>En caso contrario da click en: ";
		mensaje += "<a href=";
		mensaje += "../../modulos/solicitudDeTutoria/rechasaTutoria.php?";
		mensaje += "de="+ idTutor;
		//bug de internet explorer.
		//mensaje += '&para=' + idUsuario;
		mensaje += "&from=" + idUsuario;
		mensaje += "&nombreDelTutor=" + encodeURIComponent(nombreDelTutor);
		mensaje += "&nombreDelTema=" + encodeURIComponent(nombreDelTema);


		mensaje += '>';
		mensaje += 'No aceptar</a>';
		mensaje += '</p>'
        
        $.ajax({
            type: "POST",
            url: "../../modulos/mensajesPrivados/mensajesPrivados.php",
            typeData: "xml",
            data:{
                accion: "guarda",
                de:idUsuario,
                para: idTutor,
                asunto: asunto,
                mensaje: mensaje,
				mensaje2: mensaje2
            },
            success: function(){
                $('#m').html("Solicitud enviada a <b>" + 
                    nombreDelTutor + "</b> del tema <b>" + nombreDelTema + "</b>");
                mensaje = "";
            }
        });
		
    });
	
	buscaComponenteEjeCategoria();

//    $('#buscarPor select').change(function(){
//
//        $('#lista1,#lista2').hide();
//		$('#lista1 select').unbind('change');
//		$('#lista2 select').unbind('change');
//      
//        $('#enviarSolicitud button').prop("disabled",true); 
//
//        var buscarPor = $(this).val();       
//        
//        
//        switch(buscarPor){
//            case ("tema"):
//                $('#lista1').show("slow");
//                    //accion = temas | tutores
//                buscaTemasPorNombre();
//                break;
//            case ("tutor"):
//                $('#lista1').show("slow");
//                buscaTutoresPorNick();
//                break;
//        }
//    });
    
});

/**
 * Descarga un html con etiquetas option para ser incluido dentro de una 
 * etiqueta select.
 */
buscaTemasPorNombre = function()
{
	$.ajax({
		type: "POST",
		url: "listaDeTemasPorNombre.php",
		typeData: "html",
		success: function(html){
		
            $('#lista1 select').html(html);

            $('#lista1 select').change(function(){
                var option = $('#lista1 select>option:selected');
                $('#enviarSolicitud button').prop('disabled',true);

                idsTemas = $(this).val();
                nombreDelTema = option.text();

                buscaTutoresPorTema(idsTemas, nombreDelTema);

            })
		},
		error: error
	});
}
/**
 * Descarga un html con etiquetas option para ser incluido dentro de una 
 * etiqueta select.
 */

buscaTutoresPorNick = function()
{
    $.ajax({
        type: "POST",
        url: "listaDeTutores.php",
        typeData: "html",
        success: function(html){
            
        $('#lista1 select').html(html);
        
        $('#lista1 select').change(function(){
            
            var option = $('#lista1 select>option:selected');
            $('#enviarSolicitud button').prop('disabled',true);
            
            idTutor = $(this).val();
            nombreDelTutor = option.text();

            buscaTemasPorTutor(idTutor);
            
        });
        },
        error: error
    })
}

buscaTutoresPorTema = function(idsTemas){

	var fun_enviar = function(){
		$('#lista4').children('select').change(function(){
			var tmp = $(this).attr('value').split(',');
			idTema = tmp[0];
			idTutor = tmp[1];
			nombreDelTutor = $(this).children('option:selected').text();
			$('#enviarSolicitud button').prop('disabled',false);
		});
	}
	$('#lista4').children('select').load(
		'lib/php/listaDeTutoresPorNombreDeTema.php',
		{idsTemas:idsTemas},fun_enviar);
}

buscaTemasPorTutor = function(){

        $.ajax({
            type: "POST",
            url: "listaDeTemasPorTutor.php",
            typeData: "html",
            data:{
            idTutor: idTutor
            },
            success: function(html){
                $('#lista2 select').html(html);

                $('#lista2 select').change(function(){
                    var option = $('#lista2 select>option:selected');
                    nombreDelTema = option.text();
                    idTema = $(this).val();
                    $('#enviarSolicitud button').prop('disabled',false);
                })

                $('#lista2').show("slow");
            },
        error:error
    });
}

buscaComponenteEjeCategoria = function(){
	
	var fun_estandares = function(){
		$('#lista1').children('select').change(function(){
			$('#enviarSolicitud').children('button').prop('disabled',true);
			$('#lista3,#lista4').hide('slow');
			buscaEstandaresPorCEC($(this).val());
			$('#lista2').show('slow');
		});
	}
	
	$('#lista1').children('select').load(
		'lib/php/listaDeComponenteEjeCategoria.php',{},fun_estandares);
}

buscaEstandaresPorCEC = function(idCEC){
	
	var fun_temas = function (){
		$('#lista2').children('select').change(function(){
			$('#lista4').hide('slow');
			$('#enviarSolicitud button').prop('disabled',true);
			buscaTemasPorEstandar($(this).val());
			$('#lista3').show('slow');
		})
	}
	
	$('#lista2').children('select').load(
		'lib/php/listaDeEstandaresPorCEC.php',{idCEC:idCEC},fun_temas);
}

buscaTemasPorEstandar = function(idEstandar){
	
	var fun_tutores = function(){
		$('#lista3').children('select').change(function(){
			nombreDelTema = $(this).children('option:selected').text();
			$('#enviarSolicitud button').prop('disabled',true);
			buscaTutoresPorTema($(this).val());
			$('#lista4').show('slow');
		})
	}
	
	$('#lista3').children('select').load(
		'lib/php/listaDeTemasPorEstandar.php',{idEstandar:idEstandar},fun_tutores)
}