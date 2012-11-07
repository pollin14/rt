var iws = null // id del intervalo para la ventana subir 
var ws = null //id de la ventana.

/**
 * Esta variable es usada para tomar la pista de un temporalizador que se
 * encarga de solucionar un pequeño error con cuando se pasa el mouse
 * demaciado rapido por los cuatro botones de la pantalla loged.php
 */
var tempo;
var time = 500;
var exito = false;

recargaAvatar = function(){
    if (ws.closed){
        window.location = window.location;
        window.clearInterval(iws);
    }
}

$(document).ready(function(){
	
	$('#descripcion').hide();

	
	$('#menu li').mouseenter(function(){
		//bug de jquery
		//$('#descripcion').html( $(this).attr('value') );
		var v = this.getAttribute('value');
		window.clearInterval(tempo);
		$('#descripcion').hide();
		$('#descripcion').load('descripciones/' + v + ".html");
		$('#descripcion').show('fast');
	});
	
	$('ul li').mouseleave(function(){
            window.clearInterval(tempo);
            tempo = window.setInterval(function(){
                $('#descripcion').hide();
            },time);
		
	});
	
	//subir avatar;
	$('#misDatos img').click(function(){
        var url = REMOTE_SERVER + 'modulos/loged/subirArchivo.html?idUsuario=' + idUsuario;
	    ws = window.open(url, "subirAvatar");
        window.clearInterval(iws);
	    iws = window.setInterval(recargaAvatar, 500);
	});

})
