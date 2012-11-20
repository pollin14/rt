<?php

session_start();

header('Content-Type: text/xml; charset=UTF-8');
include "../../configuracion.php";
include "../../lib/php/utils.php";

$fecha = getActualDate();
$leido = 0;
$accion = $_POST['accion'];

$xml = '<?xml version="1.0" encoding="utf-8"?><mensajes>';

$db = dameConexion();

switch ($accion) {
	case "guarda":
		$para = $_POST['para'];
		$de = $_SESSION['idUsuario'];
		$asunto = $_POST['asunto'];
		$mensaje = $_POST['mensaje'];

		$query = sprintf('insert into MensajesPrivados 
            (de,para,asunto,mensaje,fecha,leido) values(%d,%d,\'%s\',\'%s\',"%s",%s)', $de, $para, $asunto, $mensaje, $fecha, $leido);

		if (!$db->query($query)) {
			$xml = '<?xml version="1.0" encoding="utf-8"?><mensajes>';
			$xml .= '<error><![CDATA[' . $query . '<br>' . $db->error . ']]></error>';
			$xml .= "</mensajes>";
			$db->close();
			print($xml);
			exit();
		}

		$xml .= '</mensajes>';

		//Aqui enviamos el e-mail.

		$query = sprintf('select email from Usuarios where idUsuario = %d', $para);
		$result = $db->query($query);

		if ($result->num_rows != 0) {
			$row = $result->fetch_assoc();
			$correoDeSinodal = $row['email'];
		}

		if (!mail($correoDeSinodal, $asunto, $mensaje, HEADERS_MAIL)) {
			logging("Error al enviar el email a: <b>" . $correoDeSinodal .
					"</b> con el asunto: <b>" . $asunto .
					"</b> y mensaje: <b>" . $mensaje . "</b>", $db);
		}

		break;
	case "lista":

		$para = $_SESSION['idUsuario'];
		$query = sprintf('
select 
    mp . *, u.nombre as para_nombre, u2.nombre as de_nombre
from
    ((MensajesPrivados as mp
    left join Usuarios as u ON u.idUsuario = mp.para)
    left join Usuarios as u2 ON u2.idUsuario = mp.de)
where
    mp.para = u.idUsuario
        and u.idUsuario = %d;', $para);

		$result = $db->query($query);

		if (!$result) {
			$xml = '<?xml version="1.0" encoding="utf-8"?><mensajes>';
			$xml .= '<error><![CDATA[' . $query . ']]></error>';
			$xml .= "</mensajes>";
			$db->close();
			print($xml);
			exit();
		}

		while ($row = $result->fetch_assoc()) {

			$result2 = $db->query($query);

			if (!$result2) {
				$xml = '<?xml version="1.0" encoding="utf-8"?><mensajes>';
				$xml .= '<error><![CDATA[' . $query . ']]></error>';
				$xml .= "</mensajes>";
				$db->close();
				print($xml);
				exit();
			}

			$deNick = $result2->fetch_assoc();


			$xml .= "<mensaje";
			$xml .= ' idMensajePrivado="' . $row['idMensajePrivado'] . '"';
			$xml .= ' fecha="' . $row['fecha'] . '"';
			$xml .= ' de="' . $row['de_nombre'] . '"';
			$xml .= ' para="' . $row['para_nombre'] . '"';
			$xml .= ' asunto="' . $row['asunto'] . '"';
			$xml .= ' leido="' . $row['leido'] . '"';
			$xml .= '>';
			$xml .= "</mensaje>";
		}

		$xml .= "</mensajes>";
		$result->free();
		break;
	case ("extrae"):

		$idMensajePrivado = $_POST['idMensajePrivado'];
		$query = sprintf('select mensaje,fecha 
            from MensajesPrivados 
            where idMensajePrivado = %d', $idMensajePrivado);

		$result = $db->query($query);

		if (!$result) {
			$xml = '<?xml version="1.0" encoding="utf-8"?><mensajes>';
			$xml .= '<error><![CDATA[' . $query . ']]></error>';
			$xml .= "</mensajes>";
			$db->close();
			print($xml);
			exit();
		}

		if ($result->num_rows != 0) {
			$row = $result->fetch_assoc();
			$xml .= '<mensaje fecha="' . $row['fecha'] . '"><![CDATA[' . $row['mensaje'] . ']]></mensaje>';
		}
		$xml .= '</mensajes>';

		$query = sprintf("update MensajesPrivados set leido = true
                where idMensajePrivado = %d;", $idMensajePrivado);
		if (!$db->query($query)) {
			echo "error al actualizar";
		}
		break;
}
$db->close();
print($xml);
?>