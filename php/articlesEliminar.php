<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$idArt = $_GET['idArt'];

$sql = "DELETE FROM tienda.tda_tbl_articulo WHERE id_art = '".$idArt."'";
$res = executeQuery($sql);

header('Location: articles.php');

?>