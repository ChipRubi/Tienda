<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$id = $_POST['idEditar'];
$nombre = $_POST['nombreEditar'];
$clave = $_POST['claveEditar'];
$precio = $_POST['precioEditar'];
$cantidad = $_POST['cantidadEditar'];
$descripcion = $_POST['descripcionEditar'];
$inventario = $_POST['inventarioEditar'];

$sql = "
	UPDATE tienda.tda_tbl_articulo 
	SET 
		nombre_art = '".$nombre."', 
		clave_art = '".$clave."',
		precio_art = '".$precio."',
		descripcion_art = '".$descripcion."' 
	WHERE id_art = '".$id."'";
$res = executeQuery($sql);

$sql = "
	UPDATE tienda.tda_rel_inventario_articulo 
	SET 
		cantidad_rel_inv_art = '".$cantidad."', 
		id_inv_rel_inv_art = '".$inventario."' 
	WHERE id_art_rel_inv_art = '".$id."'";
$res = executeQuery($sql);

header('Location: articles.php');

?>
