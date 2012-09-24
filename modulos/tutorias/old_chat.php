<?php
session_start();
header('Content-Type: text/xml; charset=UTF-8');

include "../../configuracion.php";
include "../../lib/php/utils.php";

/*Construimos el xml a partir de los datos recuperados de la tabla;
 *
 * El xml tiene el siguiente formato:
 * 
 * <mensajes>
 *   <mensaje idUsuario="victor" fecha="2012-07-11 01:27:00">
 *      Un mensaje de ejemplo :)
 *   </mensaje>
 *   <mensaje idUsuario="masterchif" fecha="2012-07-11 01:28:00">
 *      Mensaje desde Halo :)
 *   </mensaje>
 *   <ultimaverificacion ultimoMili="2">2012-07-11 01:28:00</ultimaverificacion>
 *   <error>Errores </error>
 * </mensajes>
 * 
 * La unica etiqueta obligatoria dentro de <mensajes> es <ultimaverificacion>
 */

//Datos enviados por el usuario.
$idTutoria = $_POST['idTutoria'];
$idUsuario = $_SESSION['idUsuario'];
$mensaje = $_POST['mensaje'];
$idEtapa = $_POST['idEtapa'];
$tipoDeUsuario = $_POST['tipoDeUsuario'];
$ultimoMili = $_POST['ultimoMili']; //Se utiliza para hacer unica la fecha.
$ultimaVerificacion = $_POST['ultimaVerificacion'];

//Regresaresmo un archivo xml con elemento root = mensajes.

$fecha = getActualDate();
$borrar = "1"; //minutos
$etapaDemostracion = 5;
$autorizacion = ($tipoDeUsuario === "sinodal")? 0: 1;
$error = "";

$db = dameConexion();

//Comprobamos conexion;
if(!$db){ die ("Error al conectarse a la base de datos. " .$db->connect_error);}

//Guardamos el mensaje nuevo;
if($mensaje != ""){
    $query = "call guardaMensaje(?,?,?,?,?,?,@mili);";
    $stmt = $db ->stmt_init(); 
    $stmt->prepare($query);
    $stmt->bind_param("ddssdd", $idTutoria,$idUsuario,$fecha,$mensaje,$autorizacion,$idEtapa);
    if(! $stmt->execute() ){
        $xml = '<?xml version="1.0" encoding="utf-8"?><mensajes>'; 
        $xml .= "<error><![CDATA[";
        $xml .= "Error al llamer store procedure guardarMensaje.";
        $xml .= sprintf("Parametros: %d, %d, %s, %s, %d, %d", 
                $idTutoria,$idUsuario,$fecha,$mensaje,$autorizacion,$idEtapa);
        $xml .= "]]></error>";
        $xml .= "</mensajes>";
        print($xml);
        $stmt ->close();
        $db -> close();
        exit();
    }
    $stmt->close();
}


//Esta variable es usada unicamente el if siguiente.
//$tmp = ($fecha == $ultimaVerificacion)? ">=": ">";
//$tmp = ">";

//Borramos mensajes viejos.
$query = sprintf('
    delete from Mensajes 
        where idtutoria=%d and fecha < DATE_SUB("%s", INTERVAL %d MINUTE);'
        ,$idTutoria,$fecha, $borrar);

if(! $db -> query($query)){
    echo $query;
}

//Recuperamos los mensajes nuevos. Si se ralizo una insercion
//(la condicion anterior) tambien se recupera esta ultima insercion.
if ($idEtapa < $etapaDemostracion ){
    $query = sprintf('select m.*, u.nick 
                    from Mensajes as m, Usuarios as u
                        where 
                            m.idTutoria = %1$d and 
                            u.idUsuario = m.idUsuario and
                            (m.fecha > "%2$s" or
                                (m.fecha = "%2$s" and m.mili > %3$d));',
            $idTutoria, $ultimaVerificacion , $ultimoMili);
    $error .= $query;
}else{ //la etapa
    $query = sprintf('select m.*, u.nick 
                    from Mensajes as m, Usuarios as u
                        where 
                            m.idTutoria = %1$d and 
                            autorizacion = true and
                            m.idUsuario = u.idUsuario and
                            (m.fecha > "%2$s" or
                                (m.fecha = "%2$s" and m.mili > %3$d));',
            $idTutoria, $ultimaVerificacion, $ultimoMili); 
    $error .= $query;
}


// Creamos el xml
$xml = '<?xml version="1.0" encoding="utf-8"?><mensajes>'; 

$result = $db->query($query);
  
while($result && $row = $result->fetch_assoc()){
    $xml .= '<mensaje' .
            ' idUsuario="' . $row['idUsuario'] . '"'.
            ' nick="' . $row['nick'] . '"' .
            ' fecha="'. $row['fecha']  .'"' .
            ' ultimoMili="' . $row['mili'] . '">';
    $xml .= '<![CDATA[';
    $xml .= $row['mensaje'];
    $xml .= ']]>';
    $xml .= '</mensaje>';
    
    //Guardamos el milisegundo (mili) y la fecha del ultimo mensaje.
    $ultimoMili = $row['mili'];
    $ultimaVerificacion = $fecha;
    
    if ($idEtapa < $row['idEtapa']){
        $idEtapa = $row['idEtapa'];
    }
    
}

 $result = $db->query('
	 select count(*) as numPro 
	 from Productos 
	 where idTutoria = ' . $idTutoria . ';');

 if (!$result) die ("Error: " .$db->error);
 
 $row = $result->fetch_row();
 
 $xml .= "<productosnuevos>" . $row[0] . "</productosnuevos>";

$xml .= "<ultimaverificacion ultimoMili=\"" . $ultimoMili . "\">" ;
$xml .= $ultimaVerificacion . "</ultimaverificacion>";
$xml .= '<ultimaetapa>' . $idEtapa .'</ultimaetapa>' ;
$xml .= "</mensajes>";

if( $result && $result->free());

$db->close();

print($xml);

?>
