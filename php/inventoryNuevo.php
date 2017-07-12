<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$nombre = $_POST['nombreNuevo'];
$descripcion = $_POST['descripcionNuevo'];
$categoria = $_POST['categoriaNuevo'];
$fecha = getdate();
$creacion = $fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'].' '.$fecha['hours'].':'.$fecha['minutes'].':'.$fecha['seconds'];

$sql = "
INSERT INTO tda_tbl_inventario (
	nombre_inv, 
	creacion_inv, 
	descripcion_inv, 
	id_cat_inv
) VALUES (
	'".$nombre."', 
	'".$creacion."', 
	'".$descripcion."', 
	".$categoria." 
)";
$res = executeQuery($sql);

header('Location: inventory.php');

?>