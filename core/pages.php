<?php 

function getHead($style=''){
	// Obtener plantilla
	$head = file_get_contents('../html/head.html');
	// Reemplazar el contenido
	$head = str_replace('[STYLE_PERSONAL]', $style, $head);
	// Retornar head
	return $head;
}

function getScripts($scr=''){
	// Obtener plantilla
	$scripts = file_get_contents('../html/scripts.html');
	// Reemplazar el contenido
	$scripts = str_replace('[SCRIPT_PERSONAL]', $scr, $scripts);
	// Retornar scripts
	return $scripts;
}

?>