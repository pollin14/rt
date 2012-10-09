var lista="";
var nodoPadre;
var anterior;
function temas(accion,padre){
    $.ajax({
        type:"POST",
        url:"lib/php/buscaTemasLinaje.php",
        dataType: "xml",
        data:{
            accion: accion
        },
        success: escribeTemas
    })
}



function escribeTemas(xml){
    $(xml).find("tema").each(function(){
        anterior=$('#temas').html();
        lista  = '<ul>';
        lista += '<li';
        lista += ' idTema="'+$(this).attr('idTema')+'"';
        lista += ' padre="'+$(this).attr('padre')+'"';
        lista += ' nick="'+$(this).attr('nick')+'"';
        lista += '>';
        if($(this).attr('esPadre')=='si'){
        lista += '<button name="hijos">+</button>';
        }
        lista += '<span>';
        lista += $(this).text();
        lista += '</span>';
        lista += '<button name="info">></button>';
        lista += '<div id="tableInfo" style="display : none">';
        lista += '<table border="1"><tr><td>ID Tema</td><td>'+$(this).attr('idTema')+'</td></tr>';
        lista += '<tr><td>Tutor</td><td>'+$(this).attr('nick')+'</td></tr>';
        lista += '</table>'
        lista += '</div>';
        lista += '</li>';
        lista += '</ul>';
        $('#temas').html(anterior+lista);
    })       

    $('[name="hijos"]').click(function(event){
        busca(event);
    });
    $('[name="info"]').click(function(event){
        informacion(event);
    })
    lista="";
    anterior="";
    nodoPadre="";
}

function busca(event){

    var idTema = event.target.parentNode.getAttribute('idTema');
    nodoPadre = event.target.parentNode;
    anterior = nodoPadre.innerHTML;

    $.ajax({
        type:"POST",
        url:'lib/php/buscaTemas.php',
        dataType:'xml',
        data:{
            accion:'hijo',
            tema: idTema
        },
        success: escribeTemasA
    });

}

function informacion(event){   
    nodoPadre=event.target.parentNode;
    var nodoP;
    var idTema =nodoPadre.getAttribute('idTema');
    var nick = nodoPadre.getAttribute('nick');
    var nombre; 
    var info;
    if(nodoPadre.firstChild.getAttribute('name')=='hijos'){
        nodoP =nodoPadre.firstChild.nextSibling;
    }else{
        nodoP =nodoPadre.firstChild;
    }
    nombre = nodoP.innerHTML;
    $(nodoP).siblings('#tableInfo').toggle();
    info='<table border="1"><tr><td>ID Tema</td><td>'+idTema+'</td></tr>';
    info+= '<tr><td>Nombre del tema</td><td>'+nombre+'</td></tr>';
    info+= '<tr><td>Tutor</td><td>'+nick+'</td></tr>';
    $('#informacion').html(info);
}



function escribeTemasA(xml){
    $(xml).find("tema").each(function(){
        lista  = '<ul>';
        lista += '<li';
        lista += ' idTema="'+$(this).attr('idTema')+'"';
        lista += ' padre="'+$(this).attr('padre')+'"';
        lista += ' nick="'+$(this).attr('nick')+'"';
        lista += '>';
        if($(this).attr('esPadre')=='si'){
        lista += '<button name="hijos">+</button>';
        }
        lista += '<span>';
        lista += $(this).text();
        lista += '</span>';
        lista += '<button name="info">?</button>';
        lista += '<div id="tableInfo" style="display : none">';
        lista += '<table border="1"><tr><td>ID Tema</td><td>'+$(this).attr('idTema')+'</td></tr>';
        lista += '<tr><td>Tutor</td><td>'+$(this).attr('nick')+'</td></tr>';
        lista += '</table>'
        lista += '</div>';
        lista += '</li>';
        lista += '</ul>';
    }) 
    nodoPadre.innerHTML= anterior + lista;
    $('[name="hijos"]').click(function(event){
        busca(event);
    });

    $('[name="info"]').click(function(event){        
        informacion(event);
    })
    lista="";
    anterior="";
    nodoPadre="";
}