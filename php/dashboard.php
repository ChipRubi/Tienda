<?php 
/* Llamar a las librerias correspondientes */
include 'checkSession.php';
include '../core/dbConnection.php';
include '../core/constants.php';
include '../core/pages.php';

/* Obtener los datos del usuario */
$sql = "SELECT * FROM tda_tbl_usuario WHERE id_usu = '".$_SESSION['sessionId']."'";
$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
    $userProfile = $dato['foto_usu'];
    $userUsuario = ucwords($dato['usuario_usu']);
}

/* Head */
print(getHead($DASHBOARD));

/* Menu */
include '../html/menu.html';

/* Contenido de la pagina */
// Crear el diccionario de datos
$diccionarioBody = array(
	'USER_PROFILE' => $userProfile,
	'USER_USUARIO' => $userUsuario
);

// Obtener la plantilla
$body = file_get_contents('../html/dashboard.html');

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}
// Mostrar el contenido
print($body);

/* Final del documento */
print(getScripts($DASHBOARD));

?>