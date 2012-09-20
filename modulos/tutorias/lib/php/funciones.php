<?php

header('Content-Type: text/html; charset=UTF-8');

function fetchUltimaEtapa($idTutoria,$db){
	//buscamos la ultima etapa
	$query = sprintf('select Max(idEtapa) as ultimaEtapa 
		from MensajesPlus where idTutoria = %d;',$idTutoria);

	$result = $db -> query($query);

	//como usa funcion de agregado (MAX) siempre nos regresara
	// por lo menos una fila.
	if(!$result ){
		return 1;
	}

	$row = $result->fetch_assoc();
	$idEtapa =  ($row['ultimaEtapa']=== null)? 1: $row['ultimaEtapa'] ;
	
	return $idEtapa;
}

function fetchMensajesNuevos(
		$idTutoria,$idUltimoMensaje,$idEtapa,$tipoDeUsuario,$tabla,$db){
	$tabla = ($tabla == "historial")? 'HistorialPlus':'MensajesPlus';
	$error = "";
	if ($idEtapa < DEMOSTRACION ){
		$query = sprintf('
			select m.*, u.nick 
			from '.$tabla .' as m natural join Usuarios as u
			where 
				m.idTutoria = %d and 
				u.idUsuario = m.idUsuario and
				m.idEtapa >= %d and
				m.idMensaje > %d;',
					$idTutoria,$idEtapa, $idUltimoMensaje);
	}else{ //Etapa 5
		if($tipoDeUsuario == "moderador"){
			//descargamos todos los mensajes incluyendo los que no estan 
			//autorizado, es decir los pendientes.
			$query = sprintf('
				select m.*, u.nick 
				from ' . $tabla . ' as m natural join usuarios as u
				where 
					m.idTutoria = %d and 
					u.idUsuario = m.idUsuario and
					m.idEtapa = %d and
					m.idMensaje > %d;',
						$idTutoria, $idEtapa,$idUltimoMensaje);
		}else{
			$query = sprintf('
			select m.*, u.nick 
			from MensajesPlus as m natural join usuarios as u
			where 
				m.idTutoria = %d and 
				u.idUsuario = m.idUsuario and
				m.autorizacion = true and
				m.idMensaje > %d;',
					$idTutoria, $idUltimoMensaje);
		}
	}

	$result = $db->query($query);

	if(!$result){
		logging("Consulta: " . $query ."\n\t" . $db->error);
		$error = "<error>Error al obtener mensajes nuevos. " .$query. "</error>";
	}
	
	$xmlP = "";
	$xmlM = "";
	while ($row = $result -> fetch_assoc()){
		if($row['autorizacion'] == "0"){//Pendientes
			$xmlP .= '<pendiente' .
					' idUsuario="' . $row['idUsuario'] . '"'.
					' nick="' . $row['nick'] . '"' .
					' idMensaje="' .$row['idMensaje'] . '"' .
					' fecha="'. $row['fecha']  .'">';
			$xmlP .= '<![CDATA[';
			$xmlP .= $row['mensaje'];
			$xmlP .= ']]>';
			$xmlP .= '</pendiente>';
		}else{
			$xmlM .= '<mensaje' .
					' idUsuario="' . $row['idUsuario'] . '"'.
					' nick="' . $row['nick'] . '"' .
					' fecha="'. $row['fecha']  .'">';
			$xmlM .= '<![CDATA[';
			$xmlM .= $row['mensaje'];
			$xmlM .= ']]>';
			$xmlM .= '</mensaje>';
		}
		
		$idUltimoMensaje= $row['idMensaje'];

		if ($idEtapa < $row['idEtapa']){
			$idEtapa = $row['idEtapa'];
		}
	}
	
	$xml = '<pendientes>' . $xmlP .'</pendientes>';
	$xml .= '<mensajes>' . $xmlM .'</mensajes>';
	$xml .= '<ultimaEtapa>' . $idEtapa .'</ultimaEtapa>' ;
	$xml .= '<idUltimoMensaje>' . $idUltimoMensaje .'</idUltimoMensaje>';
	$xml .= $error;

	return $xml;
}

function fetchNumProductos($idTutoria, $db){
	$error = "";
	$query = sprintf('
			select count(*) 
			from Productos 
			where idTutoria = %d;',$idTutoria);
	$result = $db->query($query);
	if(!$result){
		logging("Consulta: " . $query ."\n\t" . $db->error);
		$error = "<error>Error al obtener mensajes pendientes " .$query. "</error>";
	}

	$row = $result->fetch_row();

	$xml = "<productosNuevos>" . $row[0] . "</productosNuevos>";
	$xml .= $error;
	
	return $xml;
}

function saveMensaje($idTutoria,$idUsuario,$idEtapa,$autorizacion,$mensaje,$db){
	// The sended message.
	if( $mensaje != ""){
		$insert = sprintf(
				'insert into MensajesPlus 
					(idTutoria,idUsuario,idEtapa, autorizacion,mensaje) value
					(%d,%d,%d,%d,"%s");',
				$idTutoria,$idUsuario,$idEtapa,$autorizacion,$mensaje);
		if(!$db->query($insert)){
			logging("Consulta: " . $insert . "\n\t" . $db->error );
			$error = "<error>Error al guardar el mensaje</error>";
			echo $error;
		}
	}
}

function deleteMensaje($idMensaje,$db){
	$delete = sprintf('delete from MensajesPlus 
		where idMensaje = %d;', $idMensaje);
	if(!$db->query($delete)) echo "Errro al borrar mensaje.";
}
?>
