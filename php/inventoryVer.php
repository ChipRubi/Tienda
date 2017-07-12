<?php 

include 'checkSession.php';
include '../core/dbConnection.php';
include '../core/constants.php';
include '../core/pages.php';

$idInv = $_GET['idInv'];

/* Head */
print(getHead($INVENTORY));

/* Menu */
include '../html/menu.html';

$sql = "
	SELECT * 
	FROM tienda.tda_tbl_inventario 
	INNER JOIN tienda.tda_tbl_categoria ON id_cat_inv = id_cat 
	WHERE id_inv = '".$idInv."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$nombre = $dato['nombre_inv'];
	$creacion = $dato['creacion_inv'];
	$descripcion = $dato['descripcion_inv'];
	$categoria = $dato['nombre_cat'];
}

$sql = "
	SELECT * 
	FROM tienda.tda_rel_inventario_articulo 
	INNER JOIN tienda.tda_tbl_articulo ON id_art_rel_inv_art = id_art 
	INNER JOIN tienda.tda_tbl_inventario ON id_inv_rel_inv_art = id_inv
	WHERE id_inv = '".$idInv."'";
$res = executeQuery($sql);
$tabla = '';
while ($dato = $res->fetch_assoc()) {
	$tabla = $tabla.'
	<tr>
		<td><img src="'.$dato['imagen_art'].'" class="img-responsive img-thumbnail" width="80"></td>
		<td>'.ucwords($dato['nombre_art']).'</td>
		<td>'.$dato['clave_art'].'</td>
		<td>$'.$dato['precio_art'].'</td>
		<td>'.$dato['cantidad_rel_inv_art'].'</td>
		<td>'.ucwords($dato['descripcion_art']).'</td>
	</tr>';
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/inventoryVer.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'INV_ID' => $idInv,
	'INV_NOMBRE' => $nombre,
	'INV_CREACION' => $creacion,
	'INV_DESCRIPCION' => $descripcion,
	'INV_CATEGORIA' => $categoria,
	'TABLE_CONTENT' => $tabla
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

print($body);

print(getScripts($INVENTORY));

?>