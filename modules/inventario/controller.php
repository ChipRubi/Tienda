<?php

// Conectar con todos los archivos
require_once('constants.php');
require_once('model.php');
require_once('view.php');

// Capturar evento del usuario
function capturarEvento() {
    $evento = VISTA_LISTAR_INVENTARIO;
    $uriPagina = $_SERVER['REQUEST_URI'];
    $peticiones = array(
        // Peticiones para realizar acciones
        AGREGAR_INVENTARIO, 
        VER_INVENTARIO, 
        EDITAR_INVENTARIO, 
        BORRAR_INVENTARIO, 
        // Peticiones para solicitar vistas
        VISTA_AGREGAR_INVENTARIO, 
        VISTA_VER_INVENTARIO, 
        VISTA_EDITAR_INVENTARIO, 
        VISTA_BORRAR_INVENTARIO, 
        VISTA_LISTAR_INVENTARIO
    );

    // Comparar la URI actual de la pagina con todas las que tiene el modulo
    foreach ($peticiones as $peticion) {
        // Completamos la cadena tomada de las constates /inventario/peticion/
        $uriPeticion = MODULO.$peticion.'/';
        // En caso de ser iguales, es decir, es el evento que puso el usuario
        if (strpos($uriPagina, $uriPeticion) == true) {
            $evento = $peticion;
        }
    }
    return $evento;
}

// 1 Identificar el modelo
function identificarModelo() {

}

// 2 Invocar al modelo y efectuar los cambios
function invocarModelo() {

}

// 3 Enviar la informacion a la vista
function enviarDatos() {

}

echo capturarEvento();

?>