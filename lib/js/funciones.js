/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var arrayToString = function(array){
  var tmp = "";
  alert(array.length);
  for (var i = 0; i< array.length; i++){
      tmp += "mensaje"+i+ "="+array[i];
      tmp += (i != array.length-1 )? "&":"";
  }
  alert(tmp);
  return tmp;
}

  //quita los espacio en blanco al principio y al final.
  // Ejemplo de uso:
  //  var cadena = " hola ";
  //  var sin_espacios = cadena.trim();
  //
  String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");}
      
 var dameDirectorioBase = function(url){
     var end = url.lastIndexOf("/") + 1;
     return url.substring(0,end);
 }
 
 function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

autoScroll = function(div){
    $('#'+ div).scrollTop($('#' + div)[0].scrollHeight);
}

dameIdUsuario = function (){
	var idUsuario = 0;
	
	$.ajax({
		async: false,
		type: "POST",
		url: "../../lib/php/dameIdUsuario.php",
		typeData: "text",
                    
		success:function(text){
			idUsuario = parseInt(text);
		}
	});
	return idUsuario;
}

dameNickDeUsuario = function (){
	var nick = "";
	
	$.ajax({
		async: false,
		type: "POST",
		url: "../../lib/php/dameNickDeUsuario.php",
		typeData: "text",
                    
		success:function(text){
			nick = text;
		}
	});
	return nick;
}

dameNombreDeUsuario = function (){
	var n = "";
	
	$.ajax({
		async: false,
		type: "POST",
		url: "../../lib/php/dameNombreDelUsuario.php",
		typeData: "text",
                    
		success:function(text){
			n = text;
		}
	});
	return n;
}

dameNombreDelTema = function(idTutoria){
	var n = "";
	
	$.ajax({
		async: false,
		type: "POST",
		url: "../../lib/php/dameNombreDelTema.php",
		typeData: "text",
        data:{idTutoria: idTutoria},    
		success:function(text){
			n = text;
		}
	});
	return n;
}

error = function(xhr,status,error){
    $("#m").html( $("#m").html() + "<p> " + status +" -> " + error + "</p>");
}

//error = function(m){
//	$("#m").html( $("#m").html() + "<p>" + m +"</p>");
//}