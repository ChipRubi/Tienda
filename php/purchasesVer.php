<?php 

include 'checkSession.php';
include '../core/dbConnection.php';
include '../core/constants.php';
include '../core/pages.php';

$idCom = $_GET['idCom'];

/* Head */
print(getHead($INVENTORY));

/* Menu */
include '../html/menu.html';

$sql = "SELECT * FROM tienda.tda_tbl_compra WHERE id_com = '".$idCom."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$fechaInicio = $dato['fecha_hora_inicio_com'];
	$fechaFin = $dato['fecha_hora_fin_com'];
	$total = $dato['total_com'];
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
		<td><img src="'.$dato['imagen_art'].'" class="img-responsive img-thumbnail" width="50"></td>
		<td>'.$dato['nombre_art'].'</td>
		<td>'.$dato['clave_art'].'</td>
		<td>'.$dato['cantidad_rel_art_com'].'</td>
		<td>$ '.$dato['costo_rel_art_com'].'</td>
		<td>$ '.$dato['costo_rel_art_com'] * $dato['cantidad_rel_art_com'].'</td>
	</tr>';
	$contador++;
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/purchasesVer.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'COM_ID' => $idCom, 
	'COM_FECHA_INICIO' => $fechaInicio, 
	'COM_FECHA_FIN' => $fechaFin, 
	'COM_TOTAL' => $total, 
	'TABLE_CONTENT' => $tabla
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

print($body);

print(getScripts($INVENTORY));

?>