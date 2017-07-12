<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$id = $_POST['idEditar'];
$nombres = $_POST['nombresEditar'];
$apellidos = $_POST['apellidosEditar'];
$usuario = $_POST['usuarioEditar'];
$correo = $_POST['correoEditar'];

$sql = "
	UPDATE tienda.tda_tbl_usuario 
	SET nombres_usu = '".$nombres."', 
		apellidos_usu = '".$apellidos."', 
		usuario_usu = '".$usuario."', 
		correo_usu = '".$correo."' 
	WHERE id_usu = ".$id;

$res = executeQuery($sql);

header('Location: userSettings.php');

?>
