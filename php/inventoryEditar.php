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

$sql = "SELECT * FROM tienda.tda_tbl_inventario WHERE id_inv = '".$idInv."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$nombre = $dato['nombre_inv'];
	$descripcion = $dato['descripcion_inv'];
	$categoria = $dato['id_cat_inv'];
}

$sql = "SELECT * FROM tienda.tda_tbl_categoria";
$res = executeQuery($sql);
$select = '';
while ($dato = $res->fetch_assoc()) {
	if ($dato['id_cat'] == $categoria) {
		$select = $select.'<option value="'.$dato['id_cat'].'">'.ucwords($dato['nombre_cat']).'</option>';
	}
}

$sql = "SELECT * FROM tienda.tda_tbl_categoria";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	if ($dato['id_cat'] == $categoria) {
		continue;
	} else {
		$select = $select.'<option value="'.$dato['id_cat'].'">'.ucwords($dato['nombre_cat']).'</option>';
	}
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/inventoryEditar.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'INV_ID' => $idInv,
	'INV_NOMBRE' => $nombre,
	'INV_DESCRIPCION' => $descripcion,
	'INV_CATEGORIA' => $select
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

print($body);

print(getScripts($INVENTORY));

?>