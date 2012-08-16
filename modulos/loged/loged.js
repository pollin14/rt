$(document).ready(function(){
	
	creaPieDePagina();
	
	$('#descripcion').hide();
	
	$('ul li').click(function(){
		var v = this.getAttribute('value');
		var nd = ""; //nombre del modulo
		switch(v){
			case ('bandejaDeEntrada.html'):
				nd = 'mensajesPrivados';
				break;
			default:
				
				if (v.substr(0,5) == 'index')
					nd = '../alta_en_arbol';
				else
					nd = v.substr(0, v.length-5 );
		}
		window.location = '../' + nd + '/' + v;
	});
	
	$('#menu li').mouseenter(function(){
		//bug de jquery
		//$('#descripcion').html( $(this).attr('value') );
		$('#descripcion').load('descripciones/' + this.getAttribute('value'));
		$('#descripcion').show('fast');
	});
	
	$('ul li').mouseleave(function(){
		$('#descripcion').hide('fast');
	});
})
