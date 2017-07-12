<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$id = $_POST['idEditar'];
$nombre = $_POST['nombreEditar'];
$direccion = $_POST['direccionEditar'];
$telefono = $_POST['telefonoEditar'];
$correo = $_POST['correoEditar'];

$sql = "
	UPDATE tienda.tda_tbl_proveedor SET 
		nombre_pro = '".$nombre."', 
		direccion_pro = '".$direccion."', 
		telefono_pro = '".$telefono."', 
		correo_pro = '".$correo."' 
	WHERE id_pro = ".$id;
$res = executeQuery($sql);

header('Location: suppliers.php');

?>
