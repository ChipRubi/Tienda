<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$nombre = $_POST['nombreNuevo'];
$clave = $_POST['claveNuevo'];
$precio = $_POST['precioNuevo'];
$cantidad = $_POST['cantidadNuevo'];
$descripcion = $_POST['descripcionNuevo'];
$inventario = $_POST['inventarioNuevo'];

$destino = "../img/articles/";
$destino = $destino.basename($_FILES['fotoNuevo']['name']);
move_uploaded_file($_FILES['fotoNuevo']['tmp_name'], $destino);

$sql = "
	INSERT INTO tienda.tda_tbl_articulo (
		nombre_art, 
		clave_art,
		precio_art,
		descripcion_art,
		imagen_art
	) VALUES (
		'".$nombre."', 
		'".$clave."', 
		'".$precio."', 
		'".$descripcion."', 
		'".$destino."'
	)";
$res = executeQuery($sql);

$sql = "SELECT * FROM tienda.tda_tbl_articulo";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$id = $dato['id_art'];
}

$sql = "
	INSERT INTO tienda.tda_rel_inventario_articulo (
		cantidad_rel_inv_art, 
		id_inv_rel_inv_art, 
		id_art_rel_inv_art
	) VALUES (
		'".$cantidad."', 
		'".$inventario."', 
		'".$id."'
	)";
$res = executeQuery($sql);

header('Location: articles.php');

?>