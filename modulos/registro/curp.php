<?php
/*
 * 
 * Pruebas:
 * 1.- Si la curp existe debe mostrar los datos;
 * 2.- Si se ingresa una curp erronea se indica que la curp no existe.
 * 3.- si se ingresa una curp correcta pero no existe se indica que la curp no existe.
 * 
 */

function get_url_contents($url){
	$proxy = "168.255.203.51:10001";
	$proxy = explode(':', $proxy);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXY, $proxy[0]);
	curl_setopt($ch, CURLOPT_PROXYPORT, $proxy[1]);
	curl_setopt($ch, CURLOPT_HEADER, 1);

	$r =  curl_exec($ch);
// para ver los errores
//	echo curl_error($ch);
//	print_r(curl_getinfo($ch));

	return $r;
}


function get_field ($html,$field){
	//<td class="TablaTitulo"><span class="NotaBlanca">Segundo Apellido</span></td>\n\t<td><b class="Nota">
	//la identacion es importante por que los tabuladores cuentan como caracteres.
	$field = '<td class="TablaTitulo"><span class="NotaBlanca">' . $field . '</span></td>';
	//echo $field . "<br>";	
	$start = strpos($html, $field) + strlen($field);
	//echo "<b>" . $start . "</b>";
	$html = substr($html, $start);
	//echo $html . "<br>";
	
	$field = '<td>';
	$start = strpos($html, $field) + strlen($field);
	$html = substr($html, $start);
	//echo $html . "<br>";
	
	$field = '<b class="Nota">';
	$start = strpos($html, $field) + strlen($field);
	$x = substr($html, $start);
	//echo $x;
	$buffer = "";
	
	for( $i = 0; strlen($x); $i++){
		$c = substr($x, $i, 1);
		//echo $c ."<br>";
		if ($c == "<"){
			return $buffer;
		}else{
			$buffer .= $c;
		}
	}
}


if ( !isset ( $_GET['curp'] )){
?>

<form action="curp.php" method="get">
	<label>Ingresa tu curp</label><input type="text" name="curp" placeholder="Ingresa tu curp" size="50"/>
	<input type="submit" value="Consultar"/>
</form>

<?php

exit();
}

$curp = $_GET['curp'];


//echo get_url_contents("http://www.google.com");
$r = get_url_contents("http://consultas.curp.gob.mx/CurpSP/curp2.do;jsessionid=QkFsQhwF8fnhsbnJpp3wGJYg4pf5TxggGnzRshyDM7mpfNPvR83k!1854590099?strCurp=". $curp ."&strTipo=B");

if (strpos($r,"Es necesario proporcionar los") ||
		strpos($r,"no se encuentra en la Base de Datos Nacional")){
	echo "La curp no existe.";
	exit();
}

$pa = get_field ($r,'Primer Apellido');
$sa = get_field ($r,'Segundo Apellido');
$no = get_field ($r,'Nombre(s)');
$se = get_field ($r,'Sexo');
$fn = get_field ($r,'Fecha de Nacimiento');
$na = get_field ($r,'Nacionalidad');
$en = get_field ($r,'Entidad de Nacimiento');

echo "<p>Primer Apellido: " . ucwords(strtolower($pa)) ."</p>" ;
echo "<p>Segundo Apellido: " . ucwords(strtolower($sa)) ."</p>" ;
echo "<p>Nombre(s): " . ucwords(strtolower($no)) ."</p>" ;
echo "<p>Sexo: " . ucwords(strtolower($se)) ."</p>" ;
echo "<p>Fecha de Nacimiento: " . $fn ."</p>" ;
echo "<p>Nacionalidad: " . ucwords(strtolower($na)) ."</p>" ;
echo "<p>Entidad de Nacimiento: " . ucwords(strtolower($en)) ."</p>" ;

?>

