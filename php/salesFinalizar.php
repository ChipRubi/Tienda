<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$idVen = $_GET['idVen'];
$fecha = getdate();
$fin = $fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'].' '.$fecha['hours'].':'.$fecha['minutes'].':'.$fecha['seconds'];

// Calcular total
$sql = "
	SELECT sum(cantidad_rel_art_ven * precio_art) as total 
	FROM tienda.tda_rel_articulo_venta 
	INNER JOIN tienda.tda_tbl_articulo ON id_art_rel_art_ven = id_art 
	WHERE id_ven_rel_art_ven = '".$idVen."'";
$res = executeQuery($sql);
$total = '0';
while ($dato = $res->fetch_assoc()) {
	$total = $dato['total'];
}
echo "Total-".$total;
echo $sql;

// Establecer fecha de termino de la compra
$sql = "
	UPDATE tienda.tda_tbl_venta 
	SET 
		fecha_hora_fin_ven = '".$fin."', 
		total_ven = '".$total."' 
	WHERE id_ven = '".$idVen."'";
$res = executeQuery($sql);
echo $sql;


// Agregar los articulos al almacen
$sql = 'SELECT * FROM tienda.tda_rel_articulo_venta';
$res = executeQuery($sql);
$cantidades = array();
while ($dato = $res->fetch_assoc()) {
	$cantidades[''.$dato['id_art_rel_art_ven']] = $dato['cantidad_rel_art_ven'];
}

$sql = 'SELECT * FROM tienda.tda_rel_inventario_articulo';
$res = executeQuery($sql);
$cantidadesAnteriores = array();
while ($dato = $res->fetch_assoc()) {
	$cantidadesAnteriores[$dato['id_art_rel_inv_art']] = $dato['cantidad_rel_inv_art'];
}

foreach ($cantidades as $clave => $valor) {
	$cantidadNueva = $valor - $cantidadesAnteriores[$clave];
	$sql = "
		UPDATE tienda.tda_rel_inventario_articulo 
		SET cantidad_rel_inv_art = '".$cantidadNueva."' 
		WHERE id_art_rel_inv_art = '".$clave."'";
	$res = executeQuery($sql);
}

header('Location: sales.php');

?>