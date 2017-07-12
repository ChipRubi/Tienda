<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$nombre = $_POST['nombreNuevo'];
$direccion = $_POST['direccionNuevo'];
$telefono = $_POST['telefonoNuevo'];
$correo = $_POST['correoNuevo'];

$sql = "
	INSERT INTO tienda.tda_tbl_proveedor (
		nombre_pro, 
		direccion_pro, 
		telefono_pro, 
		correo_pro
	) VALUES (
		'".$nombre."', 
		'".$direccion."', 
		'".$telefono."', 
		'".$correo."'
	)";
$res = executeQuery($sql);

header('Location: suppliers.php');

?>