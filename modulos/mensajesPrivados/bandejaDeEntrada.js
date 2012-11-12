muestraMensaje = function(xml){
	var m = '<p>Enviado el <b>' + $(xml).find('mensaje').attr('fecha') + '</b></p>';
		m += '<hr/>';
		m+= $(xml).find('mensaje').text();
    $('#mensaje').html( m);
}

actualizaBandejaDeEntrada = function(xml){
    
    var bde = "";
    $(xml).find("mensaje").each(function(){
        
        var mensaje = "";
        
        mensaje += '<div name="mensaje" idMensajePrivado="' + $(this).attr('idMensajePrivado') +'">';
        mensaje += '<span name="de">' + $(this).attr("de") +'</span>';
        mensaje += '<span name="asunto" >' + $(this).attr("asunto") + '</span>';
        
        if ( parseInt($(this).attr("leido")))
            mensaje += '<div name="leido">leído</div>';
        else
            mensaje += '<div name="noleido">No leído</div>';
        
        mensaje += '<div style="clear:both;"></div>';
        mensaje += '</div>';
        bde += mensaje;
    });
    $('#bandejaDeEntrada').html(bde);
    
    $('div[name="mensaje"] span').click(function(){
        
        var idMensajePrivado = $(this).parent().attr("idMensajePrivado");
        
        $.ajax({
            type:"POST",
            url: "mensajesPrivados.php",
            dataType: "xml",
            data: { 
                accion :"extrae",
                idMensajePrivado:idMensajePrivado},
            success: muestraMensaje,
            error: function(){alert("Error al actualizar bandeja de entrada.")}
        });
        
        $(this).siblings('div[name:"noleido"]:first').text("leido").css('background-color','greenyellow');
        
        
    })
}

$(document).ready(function(){
    
    $('#actualizar').click(function(){
        $.ajax({
            type:"POST",
            url: "mensajesPrivados.php",
            dataType: "xml",
            data:{
                accion: "lista"
            },
            success: actualizaBandejaDeEntrada,
            error: function(){alert("Error al actualizar bandeja de entrada.")}
        })
    });
    
    $('#actualizar').click();
    
})



