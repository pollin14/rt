<?php
include '../../configuracion.php';
include '../../lib/php/Node.php';

header('Content-Type: text/html; charset=UTF-8');

$db = new mysqli('localhost', 'rt', 'r2d2', 'test');

$root = new Node(1, 'A1', null);
$max_amount_nodes = 100;
$amount_nodes = 0;
$list_children = array($root);

while ($amount_nodes < $max_amount_nodes and count($list_children) > 0){
	$father = array_pop($list_children);
	$query = sprintf('select * from arbol where id_padre = %d order by id_padre;', $father->id());
	
	$result = $db->query($query);
	
	if($result->num_rows == 0){
		$father->leaf(true);
	}
	
	while ( $row = $result->fetch_assoc() ){
		$tmp_node =new Node($row['id'],$row['nombre'],$father);
		$father->appendChild($tmp_node);
		array_push($list_children, $tmp_node);
		$amount_nodes ++;
	}
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="StyleSheet" href="../../lib/css/esviap.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" media="screen,print" href="lib/css/tree.css" />
        <script type="text/javascript" src="../../lib/js/jquery.js"></script>
        <script type="text/javascript" src="../../lib/js/funciones.js"></script>
        <script type="text/javascript">
			$(document).ready(function(){
				
				$('#controles').find('b').html( $('.tree').css('width') );
				
				$('#controles').find('.plus,.minus').click(function(){
					var x = 60;
					var width = $('.tree').css('width');
					width = width.substr(0, width.length -2 );
					width = parseInt(width);
					
					x = ($(this).attr('class') === 'plus')? x: -x;
					
					$('.tree').css('width',  width + x );
					$('#controles').find('b').html( width+x + "px");
				})
			})
		</script>
        <title></title>
    </head>
    <body>
		<?php include "../../lib/php/encabezado.php" ?>
		<div id="controles">
			<p>Tamaño (<b></b>): <button class="plus"> + </button> <button class="minus"> - </button></p>
		</div>
        <div id="wrapper">
			<div class="tree">
				<?php
				echo $root->toUL();
				?>
			</div>
        </div>
        <div id="m" style="clear:both"></div>
		<?php include "../../lib/php/pieDePagina.php" ?>
    </body>
</html>