<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$id = $_POST['idEditar'];
$nombre = $_POST['nombreEditar'];
$descripcion = $_POST['descripcionEditar'];
$categoria = $_POST['categoriaEditar'];

$sql = "
	UPDATE tienda.tda_tbl_inventario 
	SET nombre_inv = '".$nombre."', 
		descripcion_inv = '".$descripcion."', 
		id_cat_inv = '".$categoria."' 
	WHERE id_inv = ".$id;
$res = executeQuery($sql);

header('Location: inventory.php');

?>
