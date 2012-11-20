<?php

define("UTF_8", 1);
define("ASCII", 2);
define("ISO_8859_1", 3);

/*
 * Regresa la fecha en el formato de mysql. Ejemplo, 2012-12-29 11:11:11,
 */

function getActualDate() {
	$fecha = new DateTime();
	$fecha->setTimezone(new DateTimeZone('America/Mexico_City'));
	$fecha = date("Y-m-d H:i:s");
	return $fecha;
}

function codificacion($texto) {

	$c = 0;
	$ascii = true;

	for ($i = 0; $i < strlen($texto); $i++) {

		// Primer byte del i-esimo caracter del texto.
		$byte = ord($texto[$i]);

		if ($c > 0) {
			if (($byte >> 6) != 0x2) {
				return ISO_8859_1;
			} else {
				$c--;
			}
		} elseif ($byte & 0x80) {

			$ascii = false;
			if (($byte >> 5) == 0x6) {
				$c = 1;
			} elseif (($byte >> 4) == 0xE) {
				$c = 2;
			} elseif (($byte >> 3) == 0x1E) {
				$c = 3;
			} else {
				return ISO_8859_1;
			}
		}
	}

	return ($ascii) ? ASCII : UTF_8;
}

function utf8_encode_seguro($texto) {
	return (codificacion($texto) == ISO_8859_1) ? utf8_encode($texto) : $texto;
}

function dameExtension($fileName) {
	return strstr($fileName, ".");
}

/**
 * 
 * @param string $path ruta del archivo que incluye su nombre
 * @param styring $separador en windows se usa la barra invertida mientras que 
 * en linux es una barra normal.
 * @return string unicamente el nombre del archivo.
 */
function dameNombreDelArchivo($path, $separador = "/") {
	return substr($path, strrpos($path, $separador) + 1);
}

/*
 * Log errors into table log_erro
 */

function logging($texto, $db) {
	$error = error_get_last();
	$txt = $db->real_escape_string($texto) .			
			"<p>tipo:" . $error['type'] . "</p>" .
			"<p>msg:" . $error['message'] . "</p>" .
			"<p>file:" . $error['file'] . "</p>" .
			"<p>line:" . $error['line'] . "</p>";

	$insert = sprintf('insert into log (log) values ("%s");', $txt);

	$db->query($insert);
}

?>
