<?php

// 1 Crear un diccionario de datos
$diccionario = array(

);

// 2 Obtener la plantilla
function obtenerPlantilla($archivo=''){
    $direccion = '../../site_media/html/inventario/'.$archivo.'.html';
    $plantilla = file_get_contents($direccion);
    return $plantilla;
}

// 3 Remplazar el contenido
function remplazarDatos($datos, $pagina) {
    foreach ($datos as $clave => $valor) {
        $pagina = str_replace('{{'.$clave.'}}', $valor, $pagina);
    }
    return $pagina;
}

// 4 Mostrar el contenido final al usuario
function retornarVista($vista, $datos=array()) {
    global $diccionario;

    $pagina = obtenerPlantilla('template');
    $pagina = str_replace('{{formulario}}', obtenerPlantilla($vista), $pagina);
    $pagina = remplazarDatos($datos, $pagina);

    print $pagina;
}

?>