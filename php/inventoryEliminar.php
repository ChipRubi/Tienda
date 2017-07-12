<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$idInv = $_GET['idInv'];

$sql = "DELETE FROM tienda.tda_tbl_inventario WHERE id_inv = '".$idInv."'";
$res = executeQuery($sql);

header('Location: inventory.php');

?>