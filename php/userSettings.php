<?php 

include 'checkSession.php';
include '../core/dbConnection.php';
include '../core/constants.php';
include '../core/pages.php';

$sessionId = $_SESSION['sessionId'];

/* Head */
print(getHead($USER));

/* Menu */
include '../html/menu.html';

/* Body */
// Obtener los datos del usuario 
$sql = "
	SELECT * 
	FROM tda_tbl_usuario 
	INNER JOIN tda_tbl_tipo ON tda_tbl_usuario.id_tip_usu = tda_tbl_tipo.id_tip 
	WHERE id_usu = '".$sessionId."'";

$res = executeQuery($sql);
while ($dato = $res->fetch_assoc()) {
	$userNombres = ucwords($dato['nombres_usu']);
	$userApellidos = ucwords($dato['apellidos_usu']);
    $userUsuario = ucwords($dato['usuario_usu']);
    $userCorreo = $dato['correo_usu'];
    $userFoto = $dato['foto_usu'];
    $userTipo = ucwords($dato['nombre_tip']);

    $read = $dato['read_tip'];
    $add = $dato['add_tip'];
    $delete = $dato['delete_tip'];
    $edit = $dato['edit_tip'];
}

// Obtener los datos para la tabla 
$sql = '
	SELECT * 
	FROM tda_tbl_usuario 
	INNER JOIN tda_tbl_tipo ON tda_tbl_usuario.id_tip_usu = tda_tbl_tipo.id_tip';

$res = executeQuery($sql);
$tabla = '';
while ($dato = $res->fetch_assoc()) {
	if ($dato['id_usu'] == $sessionId) {
		continue;
	} else {
		$tabla = $tabla.'<tr>
			<td><img src="'.$dato['foto_usu'].'" class="img-responsive img-thumbnail" width="50"></td>
			<td>'.ucwords($dato['nombres_usu']).'</td>
			<td>'.ucwords($dato['apellidos_usu']).'</td>
			<td>'.ucwords($dato['usuario_usu']).'</td>
			<td>'.$dato['correo_usu'].'</td>
			<td>'.ucwords($dato['nombre_tip']).'</td>
			<td>
				<a href="userSettingsVer.php?idUsu='.$dato['id_usu'].'" class="btn btn-warning btn-sm [READ]">Ver</a> 
				<a href="userSettingsEditar.php?idUsu='.$dato['id_usu'].'" class="btn btn-primary btn-sm [EDIT]">Editar</a> 
				<a href="userEliminar.php?idUsu='.$dato['id_usu'].'" class="btn btn-danger btn-sm [DEL]">Eliminar</a>
			</td>
		</tr>';
	}
}

// Obtener contenido de archivos 
$body = file_get_contents('../html/userSettings.html');

// Crear el diccionario de datos
$diccionarioBody = array(
	'USER_ID' => $sessionId,
	'USER_NOMBRES' => $userNombres,
	'USER_APELLIDOS' => $userApellidos,
	'USER_USUARIO' => $userUsuario,
	'USER_CORREO' => $userCorreo,
	'USER_FOTO' => $userFoto,
	'USER_TIPO' => $userTipo,
	'TABLE_CONTENT' => $tabla
);

// Reemplazar el contenido
foreach ($diccionarioBody as $clave => $valor) {
	$body = str_replace('['.$clave.']', $valor, $body);
}

if ($read == 0) {
	$body = str_replace('[READ]', 'hidden', $body);
}

if ($add == 0) {
	$body = str_replace('[ADD]', 'hidden', $body);
}

if ($edit == 0) {
	$body = str_replace('[EDIT]', 'hidden', $body);
}

if ($delete == 0) {
	$body = str_replace('[DEL]', 'hidden', $body);
}

// Mostrar el contenido
print($body);

print(getScripts($USER));

?>