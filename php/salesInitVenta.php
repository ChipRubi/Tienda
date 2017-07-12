<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

// Obtener la ultima compra
$sql = 'SELECT * FROM tienda.tda_tbl_venta';
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$fin = $dato['fecha_hora_fin_ven'];
}

if (mysqli_num_rows($res) == 0 or $fin != null) {
	$sessionId = $_SESSION['sessionId'];
	$fecha = getdate();
	$creacion = $fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'].' '.$fecha['hours'].':'.$fecha['minutes'].':'.$fecha['seconds'];

	$sql = "INSERT INTO tienda.tda_tbl_venta (
		fecha_hora_inicio_ven, 
		id_usu_ven
	) VALUES (
		'".$creacion."',
		'".$sessionId."'
	)";
	$res = executeQuery($sql);
}

header('Location: salesVender.php');

?>