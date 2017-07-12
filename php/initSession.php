<?php 

/* Llamamos a las librerias correspondientes*/
include '../core/dbConnection.php';

/* Creamos la sesion */
session_start();

/* Obtenemos los datos del formulario */
$user = $_POST['usuarioLogin'];
$pass = $_POST['passwordLogin'];

/* Verificamos en la base de datos si existe la cuenta */
$sql = "
	SELECT * 
	FROM tienda.tda_tbl_usuario 
	WHERE usuario_usu = '".$user."' AND password_usu = md5('".$pass."')";
$resultado = executeQuery($sql);
while ($dato = $resultado->fetch_assoc()) {
    $_SESSION['sessionId'] = $dato['id_usu'];
}

header('Location: dashboard.php');

?>