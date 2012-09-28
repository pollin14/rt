$(document).ready(function(){
    $('#preview').click(function() { /*Al hacer click en el elemento con id "preview"*/        
        mostrarVentana();              /*se ejecuta la funcion mostrarVentana() */
    });
 
    $('#cerrar').click(function() { /*Al hacer click en el elemento con id "cerrar"*/
        cerrarVentana();              /*se ejecuta la funcion cerrarVentana() */
        generarCCT();
    });
})


function mostrarVentana() {
    $('#mascara').fadeTo(1000, 1.0, function() { /*Al acabar el fadeTo empezarán los 2 fadeIn */
        $('#zoom').fadeIn(1000);
        $('#cerrar').fadeIn(1000);
    }); 
}

function cerrarVentana() {
    $('#cerrar').fadeOut(1000);
    $('#zoom').fadeOut(1000, function() { /* cuando termine el $('#zoom').fadeOut empezará el fadeOut de la máscara */
        $('#mascara').fadeOut(1000);
    });
}

function generarCCT(){
    var mail= $('#mail').attr('value');
    var entidad= $('#entidad').val();
    var localidad = $('#localidad').val();
    var escuela = $('#escuela').val();
    var municipio = $('#municipio').val();
    
    $.ajax({
        type:'POST',
        url: 'lib/php/datos.php',
        data:{
            mail :      mail,
            entidad :   entidad,
            localidad : localidad,
            municipio : municipio,
            escuela :   escuela
            
        },
        success : function(){
            alert('tu CCT provisional sera enviado a tu correo electronico \n una vez reciba el CCT en su correo favor de registrarse');
            alert(mail+entidad+localidad);
        }
    })
}