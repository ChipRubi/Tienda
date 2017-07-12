<?php 

include 'checkSession.php';
include '../core/dbConnection.php';
include '../core/constants.php';
include '../core/pages.php';

$idUsu = $_GET['idUsu'];

/* Head */
print(getHead($USER));

/* Menu */
include '../html/menu.html';

$sessionId = $_SESSION['sessionId'];
$sql = "
	SELECT * 
	FROM tienda.tda_tbl_usuario 
	WHERE id_usu = '".$sessionId."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$sessionUserTipo = $dato['id_tip_usu'];
}
$normal = '';
if ($sessionUserTipo == '2') {
	$normal = 'hidden';
}

/* Body */
// Obtener los datos del usuario 
$sql = "
	SELECT * 
	FROM tda_tbl_usuario 
	INNER JOIN tda_tbl_tipo ON tda_tbl_usuario.id_tip_usu = tda_tbl_tipo.id_tip 
	WHERE id_usu = '".$idUsu."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$userNombres = ucwords($dato['nombres_usu']);
	$userApellidos = ucwords($dato['apellidos_usu']);
    $userUsuario = ucwords($dato['usuario_usu']);
    $userCorreo = $dato['correo_usu'];
    $userFoto = $dato['foto_usu'];
    $userTipo = ucwords($dato['nombre_tip']);
}

$sql = "SELECT * FROM tienda.tda_tbl_tipo";
$res = executeQuery($sql);
$select = '';
while ($dato = $res->fetch_assoc()) {
	if (ucwords($dato['nombre_tip']) == $userTipo) {
		$select = $select.'<option value="'.$dato['id_tip'].'">'.ucwords($dato['nombre_tip']).'</option>';
	}
}

$sql = "SELECT * FROM tienda.tda_tbl_tipo";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	if (ucwords($dato['nombre_tip']) == $userTipo) {
		continue;
	} else {
		$select = $select.'<option value="'.$dato['id_tip'].'">'.ucwords($dato['nombre_tip']).'</option>';
	}
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/userSettingsEditar.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'USER_ID' => $idUsu,
	'USER_NOMBRES' => $userNombres,
	'USER_APELLIDOS' => $userApellidos,
	'USER_USUARIO' => $userUsuario,
	'USER_CORREO' => $userCorreo,
	'USER_FOTO' => $userFoto,
	'USER_TIPO' => $select,
	'NORMAL' => $normal
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

// Mostrar el contenido
print($body);

print(getScripts($USER));

?>