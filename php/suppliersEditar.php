<?php 

include 'checkSession.php';
include '../core/dbConnection.php';
include '../core/constants.php';
include '../core/pages.php';

$idPro = $_GET['idPro'];

/* Head */
print(getHead($INVENTORY));

/* Menu */
include '../html/menu.html';

$sql = "
	SELECT * 
	FROM tienda.tda_tbl_proveedor 
	WHERE id_pro = '".$idPro."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$nombre = $dato['nombre_pro'];
	$direccion = $dato['direccion_pro'];
	$telefono = $dato['telefono_pro'];
	$correo = $dato['correo_pro'];
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/suppliersEditar.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'PRO_ID' => $idPro,
	'PRO_NOMBRE' => $nombre,
	'PRO_DIRECCION' => $direccion,
	'PRO_TELEFONO' => $telefono,
	'PRO_CORREO' => $correo
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

print($body);

print(getScripts($INVENTORY));

?>