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

// Obtener ID de la venta mas reciente
$sql = 'SELECT * FROM tienda.tda_tbl_venta';
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$idVen = $dato['id_ven'];
}

// Obtener los datos para la tabla 
$sql = "
	SELECT * 
	FROM tienda.tda_rel_articulo_venta 
	INNER JOIN tienda.tda_tbl_articulo ON id_art_rel_art_ven = id_art 
	WHERE id_ven_rel_art_ven = '".$idVen."'";
$res = executeQuery($sql);
$tabla = '';
$contador = 1;
while ($dato = $res->fetch_assoc()) {
	$tabla = $tabla.'
	<tr>
		<td>'.$contador.'</td>
		<td>'.$dato['nombre_art'].'</td>
		<td>'.$dato['cantidad_rel_art_ven'].'</td>
		<td>$ '.$dato['precio_art'].'</td>
		<td>$ '.$dato['precio_art'] * $dato['cantidad_rel_art_ven'].'</td>
		<td>
			<a href="salesVenderEliminar.php?id='.$dato['id_rel_art_ven'].'" class="btn btn-danger btn-sm">Eliminar</a> 
		</td>
	</tr>';
	$contador++;
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/salesVender.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'VEN_ID' => $idVen,
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