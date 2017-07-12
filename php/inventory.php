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

// Obtener los datos del usuario 
$sql = "
	SELECT * 
	FROM tienda.tda_tbl_usuario 
	INNER JOIN tienda.tda_tbl_tipo ON tda_tbl_usuario.id_tip_usu = tda_tbl_tipo.id_tip 
	WHERE id_usu = '".$sessionId."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
    $read = $dato['read_tip'];
    $add = $dato['add_tip'];
    $delete = $dato['delete_tip'];
    $edit = $dato['edit_tip'];
}

// Obtener los datos para la tabla 
$sql = '
	SELECT * 
	FROM tienda.tda_tbl_inventario 
	INNER JOIN tienda.tda_tbl_categoria ON id_cat_inv = id_cat';
$res = executeQuery($sql);
$tabla = '';
while ($dato = $res->fetch_assoc()) {
	$tabla = $tabla.'<tr>
		<td>'.$dato['id_inv'].'</td>
		<td>'.ucwords($dato['nombre_inv']).'</td>
		<td>'.ucwords($dato['creacion_inv']).'</td>
		<td>'.ucwords($dato['descripcion_inv']).'</td>
		<td>'.ucwords($dato['nombre_cat']).'</td>
		<td>
			<a href="inventoryVer.php?idInv='.$dato['id_inv'].'" class="btn btn-warning btn-sm [READ]">Ver</a> 
			<a href="inventoryEditar.php?idInv='.$dato['id_inv'].'" class="btn btn-primary btn-sm [EDIT]">Editar</a> 
			<a href="inventoryEliminar.php?idInv='.$dato['id_inv'].'" class="btn btn-danger btn-sm [DEL]">Eliminar</a>
		</td>
	</tr>';
}

// Obtener los datos para el select
$sql = 'select * from tda_tbl_categoria';
$res = executeQuery($sql);
$select = '';
while ($dato = $res->fetch_assoc()) {
	$select = $select.'<option value="'.$dato['id_cat'].'">'.ucwords($dato['nombre_cat']).'</option>';
}
// Obtener contenido de archivos 
$body = file_get_contents('../html/inventory.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'TABLE_CONTENT' => $tabla,
	'SELECT_OPTIONS' => $select
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

if ($add == 0) {
	$body = str_replace('[ADD]', 'hidden', $body);
}

if ($read == 0) {
	$body = str_replace('[READ]', 'hidden', $body);
}

if ($edit == 0) {
	$body = str_replace('[EDIT]', 'hidden', $body);
}

if ($delete == 0) {
	$body = str_replace('[DEL]', 'hidden', $body);
}

// Mostrar el contenido
print($body);

print(getScripts($INVENTORY));

?>