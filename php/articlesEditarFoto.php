<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$idArt = $_GET['idArt'];

$destino = "../img/articles/";
$destino = $destino.basename($_FILES['fotoEditar']['name']);
move_uploaded_file($_FILES['fotoEditar']['tmp_name'], $destino);

$sql = "
	UPDATE tienda.tda_tbl_articulo 
	SET imagen_art = '".$destino."' 
	WHERE id_art = '".$idArt."'";
$res = executeQuery($sql);

header('Location: articles.php');

?>