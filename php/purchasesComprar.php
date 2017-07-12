<?php 

include 'checkSession.php';
include '../core/dbConnection.php';
include '../core/constants.php';
include '../core/pages.php';

$sessionId = $_SESSION['sessionId'];

/* Head */
print(getHead($INVENTORY));

/* Menu */
include '../html/menu.html';

// Obtener ID de la compra mas reciente
$sql = 'SELECT * FROM tienda.tda_tbl_compra';
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$idCom = $dato['id_com'];
}

// Obtener los datos para la tabla 
$sql = "
	SELECT * 
	FROM tienda.tda_rel_articulo_compra 
	INNER JOIN tienda.tda_tbl_articulo ON id_art_rel_art_com = id_art 
	WHERE id_com_rel_art_com = '".$idCom."'";
$res = executeQuery($sql);
$tabla = '';
$contador = 1;
while ($dato = $res->fetch_assoc()) {
	$tabla = $tabla.'
	<tr>
		<td>'.$contador.'</td>
		<td>'.$dato['nombre_art'].'</td>
		<td>'.$dato['cantidad_rel_art_com'].'</td>
		<td>$ '.$dato['costo_rel_art_com'].'</td>
		<td>$ '.$dato['costo_rel_art_com'] * $dato['cantidad_rel_art_com'].'</td>
		<td>
			<a href="purchasesComprarEliminar.php?id='.$dato['id_rel_art_com'].'" class="btn btn-danger btn-sm">Eliminar</a> 
		</td>
	</tr>';
	$contador++;
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/purchasesComprar.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'COM_ID' => $idCom,
	'TABLE_CONTENT' => $tabla
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

// Mostrar el contenido
print($body);

print(getScripts($INVENTORY));

?>