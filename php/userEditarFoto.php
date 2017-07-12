<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$idUsu = $_GET['idUsu'];

$destino = "../img/profile/";
$destino = $destino.basename($_FILES['fotoEditar']['name']);
move_uploaded_file($_FILES['fotoEditar']['tmp_name'], $destino);

$sql = "UPDATE tienda.tda_tbl_usuario SET foto_usu = '".$destino."' WHERE id_usu = '".$idUsu."'";
$res = executeQuery($sql);

header('Location: userSettings.php');

?>