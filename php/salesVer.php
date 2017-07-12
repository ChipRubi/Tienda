<?php 

include 'checkSession.php';
include '../core/dbConnection.php';
include '../core/constants.php';
include '../core/pages.php';

$idVen = $_GET['idVen'];

/* Head */
print(getHead($INVENTORY));

/* Menu */
include '../html/menu.html';

$sql = "SELECT * FROM tienda.tda_tbl_venta WHERE id_ven = '".$idVen."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$fechaInicio = $dato['fecha_hora_inicio_ven'];
	$fechaFin = $dato['fecha_hora_fin_ven'];
	$total = $dato['total_ven'];
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
		<td><img src="'.$dato['imagen_art'].'" class="img-responsive img-thumbnail" width="50"></td>
		<td>'.$dato['nombre_art'].'</td>
		<td>'.$dato['clave_art'].'</td>
		<td>'.$dato['cantidad_rel_art_ven'].'</td>
		<td>$ '.$dato['precio_art'].'</td>
		<td>$ '.$dato['precio_art'] * $dato['cantidad_rel_art_ven'].'</td>
	</tr>';
	$contador++;
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/salesVer.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'VEN_ID' => $idVen, 
	'VEN_FECHA_INICIO' => $fechaInicio, 
	'VEN_FECHA_FIN' => $fechaFin, 
	'VEN_TOTAL' => $total, 
	'TABLE_CONTENT' => $tabla
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

print($body);

print(getScripts($INVENTORY));

?>