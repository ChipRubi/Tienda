<?php

/**
 * Clase que realiza la conexion con la base de datos y ejecuta las consultas
 */
abstract class DBAbstractModel {

    // Atributos de la conexion
    private static $db_host = 'localhost';
    private static $db_user = 'root';
    private static $db_pass = '';

    protected $db_name = '';
    protected $query;
    protected $rows = array();

    // Variables para guardar datos referentes a la conexion
    private $conexion;
    private $mensaje = "";

    // Conecttar con la base de datos
    private function openConnection() {
        $this->conexion = new mysqli($this->$db_host, $this->$db_user, $this->$db_pass, $this->$db_name);
    }

    // Desconectar la base de datos
    private function closeConnection() {
        $this->conexion->close_connection();
    }

    // Ejecutar consultas
    protected function executeQuery() {
        if ($_POST) {
            $this->openConnection();
            $this->$conexion->query($query);
            $this->closeConnection();
        } else {
            $this->mensaje = "Metodo no permitido";
        }
    }

    protected function getResultsFromQuery() {
        $this->openConnection();
        $resultado = $this->conexion->query($this->query);
        while($this->rows[] = $resultado->fetch_assoc());
        $resultado->close();
        $this->closeConnection();
        array_pop($this->rows);
    }

    // Metodos abstractos del CRUD de las clases que lo hereden
    abstract protected function get();
    abstract protected function set();
    abstract protected function edit();
    abstract protected function delete();
}

?>
