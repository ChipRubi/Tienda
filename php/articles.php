<?php 

include 'checkSession.php';
include '../core/dbConnection.php';
include '../core/constants.php';
include '../core/pages.php';

/* Head */
print(getHead($INVENTORY));

/* Menu */
include '../html/menu.html';

$sessionId = $_SESSION['sessionId'];

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
	FROM tienda.tda_rel_inventario_articulo 
	INNER JOIN tienda.tda_tbl_articulo ON id_art_rel_inv_art = id_art 
	INNER JOIN tienda.tda_tbl_inventario ON id_inv_rel_inv_art = id_inv';
$res = executeQuery($sql);
$tabla = '';
while ($dato = $res->fetch_assoc()) {
	$tabla = $tabla.'
	<tr>
		<td><img src="'.$dato['imagen_art'].'" class="img-responsive img-thumbnail" width="50"></td>
		<td>'.ucwords($dato['nombre_art']).'</td>
		<td>'.$dato['clave_art'].'</td>
		<td>$'.$dato['precio_art'].'</td>
		<td>'.$dato['cantidad_rel_inv_art'].'</td>
		<td>'.ucwords($dato['descripcion_art']).'</td>
		<td>'.ucwords($dato['nombre_inv']).'</td>
		<td>
			<a href="articlesVer.php?idArt='.$dato['id_art'].'" class="btn btn-warning btn-sm">Ver</a>
			<a href="articlesEditar.php?idArt='.$dato['id_art'].'" class="btn btn-primary btn-sm [EDIT]">Editar</a>
			<a href="articlesEliminar.php?idArt='.$dato['id_art'].'" class="btn btn-danger btn-sm [DEL]">Eliminar</a>
		</td>
	</tr>';
}

$sql = "SELECT * FROM tienda.tda_tbl_inventario";
$res = executeQuery($sql);
$select = '';
while ($dato = $res->fetch_assoc()) {
	$select = $select.'<option value="'.$dato['id_inv'].'">'.ucwords($dato['nombre_inv']).'</option>';
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/articles.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'TABLE_CONTENT' => $tabla,
	'SELECT_INVENTARIO' => $select
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

if ($add == 0) {
	$body = str_replace('[ADD]', 'hidden', $body);
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