<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$idPro = $_GET['idPro'];

$sql = "DELETE FROM tienda.tda_tbl_proveedor WHERE id_pro = '".$idPro."'";
$res = executeQuery($sql);

header('Location: suppliers.php');

?>