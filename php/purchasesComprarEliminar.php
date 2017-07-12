<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$id = $_GET['id'];

$sql = "DELETE FROM tienda.tda_rel_articulo_compra WHERE id_rel_art_com = '".$id."'";
$res = executeQuery($sql);

header('Location: purchasesComprar.php');

?>