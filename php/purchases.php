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
	FROM tienda.tda_tbl_compra 
	INNER JOIN tienda.tda_tbl_usuario ON id_usu = id_usu_com';
$res = executeQuery($sql);
$tabla = '';
while ($dato = $res->fetch_assoc()) {
	$tabla = $tabla.'
	<tr>
		<td>'.$dato['usuario_usu'].'</td>
		<td>'.$dato['fecha_hora_inicio_com'].'</td>
		<td>'.$dato['fecha_hora_fin_com'].'</td>
		<td>'.$dato['total_com'].'</td>
		<td>
			<a href="purchasesVer.php?idCom='.$dato['id_com'].'" class="btn btn-warning btn-sm">Ver</a> 
		</td>
	</tr>';
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/purchases.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'TABLE_CONTENT' => $tabla
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

if ($read == 0) {
	$body = str_replace('[READ]', 'hidden', $body);
}

// Mostrar el contenido
print($body);

print(getScripts($INVENTORY));

?>