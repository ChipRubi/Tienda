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

    public function set() {

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

    public function existeInventario($datosInventario=array()){

    }

    function __construct() {
        $this->db_name = 'tienda';
    }

    function __destruct() {}
}

?>