
//Estas se incializan desde la session (url)
var idTutoria   = 0;
var idUsuario   = 0;
var tipoDeUsuario = "alumno";
var idEtapa = -1;
var etapas = new Array("cero","uno","dos","tres","Busqueda De Observadores","Demostración","Aprobado");

var autorizacion = 1;
var mensaje = "";
var idUltimoMensaje = 0;

//Para la sincronizacion de la peticiones AJAX (Todavia no implementadas.)
var hayPeticionAjax = false;
var cancelarPeticion = false;

//Etapas
var DEMOSTRACION = 5;
var BUSQUEDA_DE_SINODALES = 4;

//Variables para los ciclos
var TEMPO_CHAT = 0;
var TEMPO_SUBIR_ARCHIVO = 1;

var INTERVALO_CHAT = 3000;
var INTERVALO_SUBIR_ARCHIVO = 2500;

var tempoChat;
var tempoSubirArchivo;
//Fin de variables para los ciclos.


var winSubir = null // referencia a la ventana subir archivos. 
var winSubirArchivo = null;
var nombreDelArchivo = "";
var urlDelArchivo = "";
var esUrl = false;


//Variables para la etapa de Demostracion.
var numeroDeBoton=0; 
var numeroDeProductos = 0;

var player = "";
var rutaDelAudio = "lib/audio/mensaje_nuevo";

/*
 * Carga Mensajes Previos (solo se usa una vez)
 */
descargaMensajesPrevios = function(){
    $.ajax({
        type: "POST",
        url: "lib/php/mensajesPrevios.php",
        data: {
            idTutoria : idTutoria,
			tipoDeUsuario: tipoDeUsuario
        },
        dataType: "xml",
        success:actualizaConversacion,
        error: error
    });
};

/*
 * Actualiza con nuevos mensajes la ventana de conversacion.
 * 
 * Recibe un acrhivo xml.
 */

actualizaConversacion = function(xml){
    
	var tmp;
	
    idUltimoMensaje = parseInt($(xml).find("idUltimoMensaje").text());
    var mensajes = $(xml).find('mensajes').children();
	var pendientes = $(xml).find('pendientes').children();

    mensaje = "";
        
    //Agregra los mensajes a la ventana de conversacion.
    mensajes.each(function(){
		var conversacion = $('#ventanaDeConversacion');
		var mAnteriores = conversacion.html(); // mensajesAnteriores
		var mNuevos = "";//mensajesNuevos

		mNuevos += '<span class="fecha">' + $(this).attr("fecha") + "</span><br/>";
		mNuevos += '<div class="sbl"><div class="sbr"><div class="stl"><div class="str">'
		mNuevos += '<span class="mensaje">' + $(this).text() + "</span>";
		mNuevos += '</div></div></div></div><div class="sb">';
		mNuevos += '<img class="character" src="../../avatares/'+$(this).attr('idUsuario')+'.jpg"/>';
		mNuevos += '<b class="nick">';
		mNuevos += $(this).attr("nick") + "</b>";
		conversacion.html(mAnteriores + mNuevos);
		autoScroll("ventanaDeConversacion");
    });
	
	//Agregamos los mensajes pendientes a la ventana de pendientes
	pendientes.each(function(){
		
		var m = '<div class="mensajePendiente">';
			m += $(this).attr('fecha') +"<br/>";
			m += "De: " + $(this).attr('nick');
			m += '<div value="' + $(this).attr('idUsuario') + "," 
				+ $(this).attr('idMensaje') + '">';
			m += $(this).text()
			m += '</div>';
			m += '<button>Autorizar</button>'
			m += '</div>';
			
		$('#listaDePendientes').html( $('#listaDePendientes').html() + m);
		$('#listaDePendientes').find('button').click(function(){
			
			var pendiente = $(this).siblings('div');
			var tmp = pendiente.attr('value').split(','); 
			$(this).parent().load(
				'lib/php/autorizarMensaje.php',
				{	idTutoria : idTutoria,
					idUsuario: tmp[0], 
					idMensaje : tmp[1],
					idEtapa: DEMOSTRACION,
					mensaje: pendiente.html()
				});
			$(this).parent().hide();
		});
	});

	if(mensajes.length != 0 && 
		$('#sonidoOnOff').attr('value') == "on"){
		$('#sonido').html(player);
	}

    idEtapa = parseInt($(xml).find('ultimaEtapa').text());
    $('#etapa').text(etapas[idEtapa]);
    switch(idEtapa){
        case (DEMOSTRACION):
            if(tipoDeUsuario != "moderador" &&
                tipoDeUsuario != "demostrador" &&
                tipoDeUsuario != "sinodal" &&
				tipoDeUsuario != "observador"){
                cambiaADemostracion();
            }
		case (BUSQUEDA_DE_SINODALES):
				  $('#buscaSinodales').show();
            break;
    }
    
	tmp = parseInt($(xml).find("productosNuevos").text());
	
    if(  tmp != numeroDeProductos ){
		numeroDeProductos = tmp;
		actualizaListaDeProductos();
	}
    
    window.clearInterval(tempoChat);
    tempoChat = window.setInterval(descargaMensajesNuevos,INTERVALO_CHAT);
}

/*
 * Guarda un mensajes (si hay) y descarga los nuevos mensajes desde el
 * servidor en formato xml.
 */
descargaMensajesNuevos= function(){ 
    
    window.clearInterval(tempoChat);

    $.ajax({
    type: "POST",
    url: "lib/php/chat.php",
    data: 
        {idTutoria : idTutoria, 
        mensaje: mensaje,
        idUltimoMensaje: idUltimoMensaje,
        idEtapa: idEtapa,
        tipoDeUsuario : tipoDeUsuario,
		numeroDeProductos: numeroDeProductos},
    dataType: "xml",
    success: actualizaConversacion,
    error: error
    }); 
    
};


inicializaChat = function(){
    
    $('#mensaje').val("");
    
    $('#mensaje').keydown(function(event){
        
        var cr = $('#mensaje');
        $('#caracteresRestantes').html(
            parseInt(cr.attr('maxLength')) - cr.val().length );
        if (event.which == 13 && !event.shiftKey){
            event.preventDefault();
            $('#enviarMensaje').click();
            $('#caracteresRestantes').html( cr.attr('maxLength'));
        }
    });
  
    $('#enviarMensaje').click(function(){
        mensaje = $("#mensaje").val().trim();
		if(mensaje.lenght > 255){
			mensaje = mensaje.substr(0, 254);
		}
        //mensajes[mensajes.length] = $("#message").val();
        $("#mensaje").val("");
        //guardaMensaje();
        descargaMensajesNuevos();
    });

    $('#enviarArchivo').click(function(){
    var params = "directories=no,height=150px,";
    params += "width=500px,location=no,menubar=no,resizable=no,";
    params += "titlebar=no,toolbar=no";

    var url = "subirArchivo.html?idUsuario="+idUsuario+"&";
    url += "&crp=chat" +"&idTutoria=" + idTutoria;

    //Si el segundo parametro lleva espacios en blanco no funcionara en
    //internet explorer
    winSubirArchivo = window.open(url, "SubirArchivo", params);

    window.clearInterval(tempoSubirArchivo);
    tempoSubirArchivo = window.setInterval(
    function(){
        if (winSubirArchivo.closed && urlDelArchivo !=""){
            // Una vez que la ventana ah sido cerrada, ya no necesitamos
            // el temporalizador para subir archivos.
            window.clearInterval(tempoSubirArchivo);

            //todo conseguir nombre del urlDelArchivo
            // En el chat solo se puden eviar archivos. Urls no.
            mensaje = '<a href="' + urlDelArchivo+ '" target="_blank">';
            mensaje += urlDelArchivo + "</a>";

            nombreDelArchivo = "";
            urlDelArchivo = "";

            $('#mensaje').attr("value",mensaje);
            $('#enviarMensaje').click();
        }
    }, 
    INTERVALO_SUBIR_ARCHIVO);
    
    });
	
	$('#sonidoOnOff').click(function(){
		var tmp = "on";
		if( $(this).attr('value') == "off"){
			tmp = "on";	
			$('#sonido').html(player);
		}else{
			tmp = "off";
		}

		$(this).attr('src','../../lib/img/sonido' + tmp +'.png')
				.attr('value',tmp)
				.attr('alt','Sonido: ' + tmp);
		
	});
}

inicializaRecursos = function (){
  
  actualizaListaDeRecursos();
  
  // Abre una nueva ventana y monitoriza cuando esta se cierra
  // para actualizar la lista de recursos con el nuevo
  // archivo que se acaba de subir al servidor.
  $('#subirRecurso').click(function(){
    var params = "directories=no,height=170px,";
    params += "width=500px,location=no,menubar=yes,resizable=no,";
    params += "titlebar=yes,toolbar=yes";
    
    var url = "?idUsuario="+idUsuario+"&crp=recursos&idTutoria=" +idTutoria;
	url += "&tipoDeUsuario="+tipoDeUsuario;

    //Si el segundo parametro lleva espacios en blanco no funcionara en
    //internet explorer
    winSubirRecurso = window.open("subirArchivo.html" + url, "SubirArchivo", params);

    window.clearInterval(tempoSubirArchivo);
    tempoSubirArchvio = window.setInterval(
    function(){
        if (winSubirRecurso.closed){
            // Una vez que la ventana ah sido cerrada, ya no necesitamos
            // el temporalizador para subir archivos.
            window.clearInterval(tempoSubirArchivo);
            actualizaListaDeRecursos();
        }
    }, 
    INTERVALO_SUBIR_ARCHIVO);
  });
  
}

actualizaListaDeRecursos = function(){

    $.ajax({
        type:"post",
        url: "lib/php/listaDeProductosORecursos.php",
        data: {
			r: "si",//Basca con poner cualquier cosa.
			idTutoria:idTutoria},
        dataType: "html",
        success: function(html)
        {
            $('#recursos').html(html);
            
            var producto = $('#recursos');
            
            producto.find('p').click(function(){
				var link = $(this);
                var esUrl = (link.html().indexOf('http://') == -1)? false: true;
                var hint = link.html();
				var url = link.attr('value');
				var descripcion = link.attr('alt');
                
                if (esUrl){
                    tipo = "direccion";
                }else{
					tipo = "archivo";
                }
				
				mensaje = "Por favor revisa el siguiente "+ tipo + ": " +
                        '<a href="' + url + '" target="_blank" alt="' + descripcion +'">' + hint + '</a>';
				
                $('#mensaje').val(mensaje);
                $('#enviarMensaje').click();
            });

            //borrar Recurso
            producto.find('img').click(function(){
                    
                    var url = $(this).siblings().attr("value");
                    
                    $.ajax({
                        type:"POST",
                        url:"lib/php/borraArchivo.php",
                        context: this,
                        dataType: "text",
                        data:{
                            tipo : "recurso",
                            url : url
                        },
                        success: function(text){
                        if(text == "exito"){
                            $(this).parent().hide('slow');
                        }else{
                            error(text);
                        }
                        },
                        error: error
                    });
            });
        },
        error: error
    })
}

actualizaListaDeProductos = function(){
    $.ajax({    
        type: "POST",
        url: "lib/php/listaDeProductosORecursos.php",
        dataType: "html",
        data: {idTutoria: idTutoria},
        success: function(html){
            $('#productos').html(html);
            var productos = $('#productos');
			
			//manda el producto por el chat
			productos.find('p').click(function(){
				var link = $(this);
                var hint = link.html();
				var url = link.attr('value');
				var descripcion = link.attr('alt');
                
				mensaje = "Por favor revisa el siguiente archivo: " +
					'<a href="' + url +'" target="_blank" alt="' 
					+ descripcion +'" title="'+ descripcion+ '">' + hint + '</a>';
                $('#mensaje').val(mensaje);
                $('#enviarMensaje').click();
            });
            
            //borrar el producto
            productos.find('img').click(function(){

                url = $(this).siblings().attr('value');
                
                $.ajax({
                    type:"POST",
                    url:"lib/php/borraArchivo.php",
                    context: this,
                    dataType: "text",
                    data:{
                        tipo : "producto",
                        url : url
                    },
                    success: function(text){
                        if(text == "exito"){
                            $(this).parent().hide('slow');
                        }else{
                            error(text);
                        }
                    },
                    error: error
                });
                
            });
        },
        error: error
    });
}

inicializaProductos = function(){
  
  actualizaListaDeProductos();
  
  $('#subirProducto').click(function(){
	
    var params = "directories=no,height=200px,";
    params += "width=500px,location=no,menubar=yes,resizable=no,";
    params += "titlebar=no,toolbar=no";
    
    var url = "subirArchivo.html?idTutoria=" + idTutoria+"&crp=productos" ;
		url += "&tipoDeUsuario="+tipoDeUsuario;

    //Si el segundo parametro lleva espacios en blanco no funcionara en
    //internet explorer
    winSubirArchivo = window.open(url, "SubirArchivo", params);
  });
}

cambiaADemostracion = function(){
    
    window.clearInterval(tempoChat);
    window.clearInterval(tempoSubirArchivo);
   

//var fun = function(){
	var url = "";
    switch(tipoDeUsuario){
        case("tutor"):
            tipoDeUsuario = "moderador";
            break;
        case("alumno"):
            tipoDeUsuario = "demostrador";  
            break;
        case("observador"):
            tipoDeUsuario = "sinodal";
            break;
    }
    
    url += "tutoria.php?";
    url += "idUsuario=" + idUsuario + "&";
    url += "tipoDeUsuario=" + tipoDeUsuario +"&";
    url += "idTutoria=" + idTutoria;
    window.location = url;
//}
//window.setInterval(fun, 3000);

}

buscaSinodales = function(){   
    $.ajax({
        type:"POST",
        url: "lib/php/buscaSinodales.php",
        data:{idTutoria:idTutoria},
        error: error
    });
}

agregaTemaDeCatalogo = function(nombreDelTema){

		$.ajax({
				url:'lib/php/agregarTemaDeCatalogo.php',
				data:{
				   idTutoria: idTutoria,
				   nombre: nombreDelTema
				},
				type:'POST',
				typeData:"text",
				success:function(text){
					$('#temaCaptura').children('input').val("");
					alert(text);
					$('#añadirTemasDeCatalogo').children('button').click();
				}
			});
	}
    
inicializaAgregarTemaDeCatalogo = function(){
	$('#añadirTemaDeCatalogo').show('slow');
	$('#añadirTemaDeCatalogo').click( function(){
		$('#temaCaptura').toggle('slow');
	});
	
	$('#temaCaptura').hide();
	$('#temaCaptura').children('button').prop("disabled",true);
	
	$('#temaCaptura').children('button').click(function(){
		//$(this).siblings('input').addClass("bordeRojo");
		var nombreDelTema = $('#temaCaptura').children('input').val();

		var conf = confirm("Una vez agregado el tema no podra ser borrado.\n\
¿Estas seguro que quieres guardar el tema con el nombre "+nombreDelTema + "?");
		if(conf){
			agregaTemaDeCatalogo(nombreDelTema);
		}	
	});
	
	$('#temaCaptura input').keyup(function(){
		if( $(this).val() != ""){
			$(this).siblings('button').prop("disabled",false);
		}else{
			$(this).siblings('button').prop("disabled",true);
		}
	})
	
}


/*
 * Inicializa variables y eventos.
 */
$(document).ready(function(){
  
  tipoDeUsuario = getUrlVars()['tipoDeUsuario'];
  idTutoria = getUrlVars()['idTutoria'];
  idUsuario = dameIdUsuario();
  
  //inicializamos el reproductor de sonido segun el soporte que tenga el navegador
	var html5 = '<audio controls preload="auto" autobuffer autoplay="autoplay">';
		html5 += '<source src="' + rutaDelAudio + '.ogg" type="audio/ogg"/>';
		html5 += '<source src="' + rutaDelAudio + '.mp3" type="audio/mpeg"/>';
		html5 += '¬¬ tu navegador no soprota html. ¿porque no se cargo el flash?'
		html5 += '</audio>';
	var flash = '<object type="application/x-shockwave-flash" ';
		flash += 'data="lib/flash/dewplayer-mini.swf" ';
		flash += 'width="0" height="0" id="dewplayermini" name="dewplayermini">';
		flash += '<param name="movie" value="lib/flash/dewplayer-mini.swf" />';
		flash += '<param name="flashvars" value="mp3=' + rutaDelAudio +'.mp3&amp;autostart=1" /></object>';
	var embed = '<embed src="'+rutaDelAudio +'.mp3" type="audio/mpeg"';
		embed += 'height="0" width="0"/>'	
	if (Modernizr.audio){
		player = html5;
		$('#sonido').hide();
	}else{
		player = flash;
	}
	
	
  
  descargaMensajesPrevios();
  
  inicializaChat();
  
  //Particularidades para cada tipo de usuario.
  switch(tipoDeUsuario){
      case "tutor":
          inicializaRecursos();
          inicializaProductos();
		  inicializaAgregarTemaDeCatalogo();

          $('#siguienteEtapa').click(function(){
			  
              idEtapa++;
              switch(idEtapa){
                  case(DEMOSTRACION):
                      $('#mensaje').val("En la Etapa de Demostracion");
                      break;
				  case (BUSQUEDA_DE_SINODALES):
					  buscaSinodales();
					  $('#mensaje').val("Etapa: " + etapas[idEtapa]);
					  break;
                  default:
                      $('#mensaje').val("Etapa: " + etapas[idEtapa]);
              }
              $('#enviarMensaje').click();
          });
		  
		  $('#buscaSinodales').click(function(){
				buscaSinodales();
                //la linea de arriba deberia ser equivalente.
//                $.ajax({
//					type:'POST',
//					url:'lib/php/buscaSinodales.php',
//					data:{idTutoria:idTutoria},
//					typedata:"html",
//					error: error
//				});
				$('#mensaje').val("Buscando Observadores...");
				$('#enviarMensaje').click();
			}).hide();
		  
          break;
     case "moderador":
		  $("#añadirTemaDeCatalogo").hide();
		  
		  $('#aprobar').click(function(){
			  
			  agregaTemaDeCatalogo(dameNombreDelTema(idTutoria));
			  
			  $.ajax({
				  url:'lib/php/aprobar.php',
				  type:'POST',
				  data:{idTutoria:idTutoria},
				  typeData:"text",
				  success:function(){
					  idEtapa=6;
					  var mensaje = "¡Demostración Aprobada!";
					  mensaje += "¡Felicidades! Ahora ya puedes tutorar.";

					  $('#mensaje').val(mensaje);
					  $('#enviarMensaje').click();
				  },
				  error:error
			  });
			  
		  });
		  
          break;
     case "observador":
           $('#enviarMensaje').prop('disabled',true);
           $('#mensaje').prop('disabled',true);
           $('#enviarArchivo').prop('disabled',true);
          break;
     case "sinodal":
          autorizacion = 0;
          //inicializaComponentesDeSinodal()
          break;
     case "alumno":
         if(idEtapa == DEMOSTRACION){
            cambiaADemostracion();
         }else{
            inicializaProductos();
         }

        break;
     case "demostrador":

         //El no tiene nada especial. Solamente el chat.
     break;
     default:
         break;
  }
  
  window.clearInterval(tempoChat);
  tempoChat = window.setInterval(descargaMensajesNuevos,INTERVALO_CHAT);
});



