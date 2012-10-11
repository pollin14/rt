/*
 * Esta funcion es todolo lo que se necesita para cargar una grafica.
 * @param datos archivo json con los datos de la grafica.
 * @param div el id del div donde se cargara la grafica.
 */

function cargaGrafica(datos,div){
	swfobject.embedSWF(
		"../../lib/ofc/open-flash-chart.swf", div,
		"440", "440", "9.0.0", "expressInstall.swf",
		{
			"data-file":"graficas/datos/" + datos
		} );
}

/*
 * El conjunto de funciones siguientes es llamado desde los datos de la tabla.
 */

function muestra_tabla_temas(){
	muestra_tabla('temas.php');
}
function muestra_tabla_entidades(){
	muestra_tabla('entidades.php');
}
function muestra_tabla_usuarios(){
	muestra_tabla('usuarios.php')
}
function muestra_tabla_tutorias(){
	muestra_tabla('tutorias.php')
}
function muestra_tabla(nombre){
	$.ajax({
		type:'post',
		url: "tablas/" + nombre,
		datatype: 'html',
		success: function(html){
			$('#tabla').html(html);
			$('#tabla').find('a').click(function(){
				$('#tabla').load(encodeURI($(this).attr('title')));
			})
			$('#tabla').show('slow');
		},
		error: function(){
			alert("error");
		}
	})
} 
/* Fin del conjunto de tablas */

$(document).ready(function(){
	$(function(){
		$('#tabs').tabs();
	});
	
	$('#tabs').children('ul').find('li a').click(function(){
		$('#tabla').hide('slow');
	})
	
	cargaGrafica('temas.php','temas');
	cargaGrafica('tutorias.php','tutorias');
	cargaGrafica('entidades.php','entidades');
	cargaGrafica('usuarios.php','usuarios');
	
	$('#linaje').children('button').click(function(){
		var link = document.createElement('script');
		link.setAttribute('type', 'text/javascript');
		link.setAttribute('src', 'lib/js/arbol.js');
		
		var link2 = document.createElement('script');
		link2.setAttribute('type', 'text/javascript');
		link2.setAttribute('src', 'lib/js/portamento.js');
		
		var head = document.getElementsByTagName('head')[0];
		
		head.appendChild(link);
		head.appendChild(link2);
		
//		$('#informacion').portamento({
//			wrapper: $('#wrapper')
//		});	
		alert("waite")
		temas('todos');
	})
});

