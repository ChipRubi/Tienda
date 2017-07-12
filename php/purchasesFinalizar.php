<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$idCom = $_GET['idCom'];
$fecha = getdate();
$fin = $fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'].' '.$fecha['hours'].':'.$fecha['minutes'].':'.$fecha['seconds'];

// Calcular total
$sql = "
	SELECT sum(cantidad_rel_art_com * costo_rel_art_com) as total 
	FROM tienda.tda_rel_articulo_compra 
	WHERE id_com_rel_art_com = '".$idCom."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$total = $dato['total'];
}

// Establecer fecha de termino de la compra
$sql = "
	UPDATE tienda.tda_tbl_compra 
	SET 
		fecha_hora_fin_com = '".$fin."', 
		total_com = '".$total."' 
	WHERE id_com='".$idCom."'";
$res = executeQuery($sql);

// Agregar los articulos al almacen
$sql = 'SELECT * FROM tienda.tda_rel_articulo_compra';
$res = executeQuery($sql);
$cantidades = array();
while ($dato = $res->fetch_assoc()) {
	$cantidades[''.$dato['id_art_rel_art_com']] = $dato['cantidad_rel_art_com'];
}

$sql = 'SELECT * FROM tienda.tda_rel_inventario_articulo';
$res = executeQuery($sql);
$cantidadesAnteriores = array();
while ($dato = $res->fetch_assoc()) {
	$cantidadesAnteriores[$dato['id_art_rel_inv_art']] = $dato['cantidad_rel_inv_art'];
}

foreach ($cantidades as $clave => $valor) {
	$cantidadNueva = $valor + $cantidadesAnteriores[$clave];
	$sql = "
		UPDATE tienda.tda_rel_inventario_articulo 
		SET cantidad_rel_inv_art = '".$cantidadNueva."' 
		WHERE id_art_rel_inv_art = '".$clave."'";
	$res = executeQuery($sql);
}

header('Location: purchases.php');

?>