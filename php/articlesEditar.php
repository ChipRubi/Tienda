<?php 

include 'checkSession.php';
include '../core/dbConnection.php';
include '../core/constants.php';
include '../core/pages.php';

$idArt = $_GET['idArt'];

/* Head */
print(getHead($INVENTORY));

/* Menu */
include '../html/menu.html';

$sql = "
	SELECT * 
	FROM tienda.tda_tbl_articulo 
	INNER JOIN tienda.tda_rel_inventario_articulo ON id_art = id_art_rel_inv_art 
	INNER JOIN tienda.tda_tbl_inventario ON id_inv = id_inv_rel_inv_art 
	WHERE id_art = '".$idArt."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$foto = $dato['imagen_art'];
	$nombre = $dato['nombre_art'];
	$clave = $dato['clave_art'];
	$precio = $dato['precio_art'];
	$cantidad = $dato['cantidad_rel_inv_art'];
	$descripcion = $dato['descripcion_art'];
	$inventario = $dato['id_inv_rel_inv_art'];
}

$sql = "SELECT * FROM tienda.tda_tbl_inventario";
$res = executeQuery($sql);
$select = '';
while ($dato = $res->fetch_assoc()) {
	if ($dato['id_inv'] == $inventario) {
		$select = $select.'<option value="'.$dato['id_inv'].'">'.ucwords($dato['nombre_inv']).'</option>';
	}
}

$sql = "SELECT * FROM tienda.tda_tbl_inventario";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	if ($dato['id_inv'] == $inventario) {
		continue;
	} else {
		$select = $select.'<option value="'.$dato['id_inv'].'">'.ucwords($dato['nombre_inv']).'</option>';
	}
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/articlesEditar.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'ART_ID' => $idArt,
	'ART_FOTO' => $foto,
	'ART_NOMBRE' => $nombre,
	'ART_CLAVE' => $clave,
	'ART_PRECIO' => $precio,
	'ART_CANTIDAD' => $cantidad,
	'ART_DESCRIPCION' => $descripcion,
	'ART_INVENTARIO' => $select
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

print($body);

print(getScripts($INVENTORY));

?>