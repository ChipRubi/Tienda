<?php

require_once('../../core/db_abstract_model.php');

class Inventario extends DBAbstractModel {

    private $id;
    public $nombre;
    public $fechaCreacion;
    public $descripcion;
    public $idCategoria;
    public $categoria;
    public $listaInventarios = array();
    public $listaCategorias = array();

    public function get($id='') {
        if ($id != '') {
            $this->query = "
                SELECT
                    id_inv as id,
                    nombre_inv as nombre,
                    creacion_inv as fechaCreacion,
                    descripcion_inv as descripcion,
                    id_cat_inv as idCategoria,
                    nombre_cat as categoria
                FROM tienda.tda_tbl_inventario
                INNER JOIN tienda.tda_tbl_categoria ON id_cat_inv = id_cat
                WHERE id_inv = '$id'
            ";
            $this->getResultsFromQuery();
        }

        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                if ($propiedad == 'id') {
                    $this->id = $valor;
                } else if ($propiedad == 'nombre') {
                    $this->nombre = $valor;
                } else if ($propiedad == 'fechaCreacion') {
                    $this->fechaCreacion = $valor;
                } elseif ($propiedad == 'descripcion') {
                    $this->descripcion = $valor;
                } elseif ($propiedad == 'idCategoria') {
                    $this->idCategoria = $valor;
                } elseif ($propiedad == 'categoria') {
                    $this->categoria = $valor;
                }
            }
        }
    }

    public function set($datos=array()) {
        if (array_key_exists('nombre', $datos) && array_key_exists('descripcion', $datos) && array_key_exists('idCategoria', $datos)) {
            $this->getInventarios();
            // Determina si los datos ingresados corresponden al de algun registro existente
            $existeInventario = false;
            foreach ($this->listaInventarios as $fila) {
                if ((strcasecmp($datos['nombre'], $fila['nombre']) == 0)  && (strcasecmp($datos['idCategoria'], $fila['idCategoria']) == 0)) {
                    $existeInventario = true;
                }
            }

            if (!$existeInventario) {
                $fecha = getdate();

                $this->nombre = $datos['nombre'];
                $this->fechaCreacion = 
                    $fecha['year'].'-'.
                    $fecha['mon'].'-'.
                    $fecha['mday'].' '.
                    $fecha['hours'].':'.
                    $fecha['minutes'].':'.
                    $fecha['seconds']
                ;
                $this->descripcion = $datos['descripcion'];
                $this->idCategoria = $datos['idCategoria'];
                $this->query = "
                    INSERT INTO tda_tbl_inventario (
                        nombre_inv, 
                        creacion_inv, 
                        descripcion_inv, 
                        id_cat_inv
                    ) VALUES (
                        '$this->nombre', 
                        '$this->fechaCreacion', 
                        '$this->descripcion', 
                        '$this->idCategoria'
                    )
                ";
                $this->executeQuery();
                $this->mensaje = 'Inventario agregado exitosamente';
            } else {
                $this->mensaje = 'El inventario ya existe';
            }
        } else {
            $this->mensaje = "No se ha creado el inventario";
        }
    }

    public function edit() {

    }

    public function delete($id='') {

    }

    public function getInventarios() {
        $this->query = "
            SELECT 
                id_inv as id,
                nombre_inv as nombre,
                creacion_inv as fechaCreacion,
                descripcion_inv as descripcion,
                id_cat_inv as idCategoria,
                nombre_cat as categoria
            FROM tienda.tda_tbl_inventario
            INNER JOIN tienda.tda_tbl_categoria ON id_cat_inv = id_cat
        ";
        $this->getResultsFromQuery();
        if (count($this->rows) >= 1) {
            $this->listaInventarios = $this->rows;
        } else {
            $this->mensaje = 'No hay ningun inventario';
        }
    }

    public function getCategorias() {
        $this->query = "
            SELECT id_cat as id, nombre_cat as nombre
            FROM tienda.tda_tbl_categoria
        ";
        $this->getResultsFromQuery();
        if (count($this->rows) >= 1) {
            $this->listaCategorias = $this->rows;
        } else {
            $this->mensaje = 'No hay ninguna categoria';
        }
    }

    function __construct() {
        $this->db_name = 'tienda';
    }

    function __destruct() {}
}

?>