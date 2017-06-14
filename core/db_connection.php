<?php

/**
 * Clase que realiza la conexion con la base de datos y ejecuta las consultas
 */
abstract class db_connection {

    // Atributos de la conexion
    private $db_host = "";
    private $db_user = "";
    private $db_pass = "";
    private $db_name = "";
    private $query;

    //Getters and Setters
    public function getDbHost() {
        return $this->$db_host;
    }
    public function setDbHost($db_host = "") {
        $this->$db_host = $db_host;
    }

    public function getDbUser() {
        return $this->$db_user;
    }
    public function setDbUser($db_user = "") {
        $this->$db_user = $db_user;
    }

    public function getDbPass() {
        return $this->$db_pass;
    }
    public function setDbPass($db_pass = "") {
        $this->$db_pass = $db_pass;
    }

    public function getDbName() {
        return $this->$db_name;
    }
    public function setDbName($db_name = "") {
        $this->$db_name = $db_name;
    }

    public function getQuery() {
        return $this->$query;
    }
    public function setQuery($query = "") {
        $this->$query = $query;
    }

    // Variables para guardar datos referentes a la conexion
    protected $conn;

    // Conecttar con la base de datos
    public function openConnection() {
        $this->conn = new mysqli($this->$db_host, $this->$db_user, $this->$db_pass, $this->$db_name);
    }

    //Desconectar la base de datos
    public function closeConnection() {
        $this->conn->close_connection();
    }

    //Ejeccutar consultas
    protected function executeQuery($query = $this->$query) {
        $this->openConnection();
        $this->$conn->query($query);
        $this->closeConnection();
    }

    // Metodos abstractos del CRUD de las clases que lo hereden
    abstract function get();
    abstract function set();
    abstract function edit();
    abstract function delete();
}

?>
