<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$idCom = $_POST['idCompra'];
$clave = $_POST['claveArticulo'];
$cantidad = $_POST['cantidadArticulo'];
$costo = $_POST['costoArticulo'];

$sql = "SELECT * FROM tienda.tda_tbl_articulo WHERE clave_art = '".$clave."'";
$res = executeQuery($sql);
if ($res) {
	while ($dato = $res->fetch_assoc()) {
		$idArt = $dato['id_art'];
	}

	$sql = "
		SELECT * 
		FROM tienda.tda_rel_articulo_compra 
		WHERE id_com_rel_art_com  = '".$idCom."' AND id_art_rel_art_com = '".$idArt."'";
	$res = executeQuery($sql);

	$existe = false;
	if ($res) {
		while ($dato = $res->fetch_assoc()) {
			$existe = true;
			$idRel = $dato['id_rel_art_com'];
			$cantidadAnterior = $dato['cantidad_rel_art_com'];
		}
	}

	echo $existe;
	if ($existe) {
		$cantidadNueva = $cantidadAnterior + $cantidad;
		$sql = "
			UPDATE tienda.tda_rel_articulo_compra 
			SET cantidad_rel_art_com = '".$cantidadNueva."' 
			WHERE id_rel_art_com = '".$idRel."'";
	} else {
		$sql = "
			INSERT INTO tienda.tda_rel_articulo_compra (
				cantidad_rel_art_com, 
				costo_rel_art_com,
				id_art_rel_art_com,
				id_com_rel_art_com
			) VALUES (
				'".$cantidad."', 
				'".$costo."', 
				'".$idArt."', 
				'".$idCom."'
			)";
	}
	$res = executeQuery($sql);
}

header('Location: purchasesComprar.php');

?>