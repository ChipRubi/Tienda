<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$id = $_GET['id'];

$sql = "DELETE FROM tienda.tda_rel_articulo_venta WHERE id_rel_art_ven = '".$id."'";
$res = executeQuery($sql);

header('Location: salesVender.php');

?>