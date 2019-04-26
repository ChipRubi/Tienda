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
// Funcion vacia debido a que el modulo solo tiene un modelo que es Inventario
function identificarModelo() {}

// 2 Invocar al modelo y efectuar los cambios
function invocarModelo() {
    $inventario = new Inventario();
    return $inventario;
}

// 3 Enviar la informacion a la vista
function enviarDatos() {
    $inventario = invocarModelo();
    $evento = capturarEvento();

    switch ($evento) {
        case AGREGAR_INVENTARIO:
            
            break;
        
        case VER_INVENTARIO:
            
            break;

        case EDITAR_INVENTARIO:
            
            break;
        
        case BORRAR_INVENTARIO:
            
            break;
            
        case VISTA_LISTAR_INVENTARIO:
            $inventario->getAll();
            $datos = array(
                'lista_inventario' => obtenerListaInventarios($inventario),
                'opciones_categoria' => '',
                'mensaje' => $inventario->mensaje
            );
            retornarVista(VISTA_LISTAR_INVENTARIO, $datos);
            break;

        default:
            
            break;
    }
}

// Funciones auxiliares
function obtenerListaInventarios($inventario){
    $tabla = '';
    $lista = $inventario->lista;
    foreach ($lista as $fila) {
        $tabla = $tabla.obtenerPlantilla('tabla');
        $tabla = remplazarDatos($fila, $tabla);
    }
    return $tabla;
}

echo capturarEvento();
enviarDatos();

?>