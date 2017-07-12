<?php 

include 'checkSession.php';
include '../core/dbConnection.php';

$idUsu = $_GET['idUsu'];

$sql = '
	SELECT * FROM tienda.tda_tbl_usuario 
	INNER JOIN tienda.tda_rel_usuario_compra ON id_usu = id_usu_rel_usu_com 
	INNER JOIN tienda.tda_rel_usuario_venta ON id_usu = id_usu_rel_usu_ven 
	WHERE id_usu = '.$idUsu
;

$sql = 'DELETE FROM tienda.tda_tbl_usuario WHERE id_usu = '.$idUsu;
$res = executeQuery($sql);
header('Location: userSettings.php');

?>