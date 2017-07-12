<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$nombres = $_POST['nombresNuevo'];
$apellidos = $_POST['apellidosNuevo'];
$usuario = $_POST['usuarioNuevo'];
$correo = $_POST['correoNuevo'];
$password = $_POST['passwordNuevo'];

$destino = "../img/profile/";
$destino = $destino.basename($_FILES['fotoNuevo']['name']);
move_uploaded_file($_FILES['fotoNuevo']['tmp_name'], $destino);

$sql = "
	INSERT INTO tienda.tda_tbl_usuario (
		nombres_usu, 
		apellidos_usu, 
		usuario_usu, 
		correo_usu, 
		password_usu, 
		foto_usu, 
		id_tip_usu
	) VALUES (
		'".$nombres."', 
		'".$apellidos."', 
		'".$usuario."', 
		'".$correo."', 
		md5('".$password."'), 
		'".$destino."', 
		'2'
	)";
$res = executeQuery($sql);

header('Location: userSettings.php');

?>