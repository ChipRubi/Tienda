<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$idVen = $_POST['idVenta'];
$clave = $_POST['claveArticulo'];
$cantidad = $_POST['cantidadArticulo'];

$sql = "
	SELECT * 
	FROM tienda.tda_tbl_articulo 
	INNER JOIN tienda.tda_rel_inventario_articulo ON id_art = id_art_rel_inv_art 
	WHERE clave_art = '".$clave."'";
$res = executeQuery($sql);

if ($res) {
	while ($dato = $res->fetch_assoc()) {
		$idArt = $dato['id_art'];
		$cantidadInventario = $dato['cantidad_rel_inv_art'];
	}

	if ($cantidadInventario != 0) {
		$sql = "
			SELECT * 
			FROM tienda.tda_rel_articulo_venta 
			WHERE id_ven_rel_art_ven  = '".$idVen."' AND id_art_rel_art_ven = '".$idArt."'";
		$res = executeQuery($sql);

		$existe = false;
		if ($res) {
			while ($dato = $res->fetch_assoc()) {
				$existe = true;
				$idRel = $dato['id_rel_art_ven'];
				$cantidadAnterior = $dato['cantidad_rel_art_ven'];
			}
		}

		if ($existe) {
			$cantidadNueva = $cantidadAnterior + $cantidad;
			if (($cantidadInventario - $cantidadNueva) >= 0) {
				$sql = "
				UPDATE tienda.tda_rel_articulo_venta 
				SET cantidad_rel_art_ven = '".$cantidadNueva."' 
				WHERE id_rel_art_ven = '".$idRel."'";
			}
		} else {
			$sql = "
				INSERT INTO tienda.tda_rel_articulo_venta (
					cantidad_rel_art_ven, 
					id_art_rel_art_ven,
					id_ven_rel_art_ven
				) VALUES (
					'".$cantidad."', 
					'".$idArt."', 
					'".$idVen."'
				)";
		}
		$res = executeQuery($sql);
	}
}

header('Location: salesVender.php');

?>