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
        if(exito){
            window.location = window.location;
        }
        window.clearInterval(iws);
    }
}

$(document).ready(function(){
	
	$('#descripcion').hide();
	
	$('ul li').click(function(){
		var v = this.getAttribute('value');
		var nd = v; //nombre del modulo
		switch(v){
			case ('bandejaDeEntrada'):
				nd = 'mensajesPrivados';
				v += ".php";
				break;
			default:
				if (v.substr(0,5) == 'index'){
					nd = 'alta_en_arbol';
				}else{
				    v = v + ".php";
				}
		}
		window.location = '../' + nd + '/' + v;
	});
	
	$('#menu li').mouseenter(function(){
		//bug de jquery
		//$('#descripcion').html( $(this).attr('value') );
		var v = this.getAttribute('value');
		if (v.substr(0,5) == 'index'){
		  v = "misTemasDeCatalogo";
	     }
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
        var params = "directories=no,height=150px,";
        params += "width=500px,location=no,menubar=no,resizable=no,";
        params += "titlebar=no,toolbar=no";
        
	    ws = window.open("subirArchivo.html", "subirAvatar",params);
        window.clearInterval(iws);
	    iws = window.setInterval(recargaAvatar, 500);
	});

})
