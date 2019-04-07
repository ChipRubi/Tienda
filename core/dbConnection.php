<?php

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "tienda";

function getConnection(){
    $connection = new mysqli($GLOBALS['dbHost'], $GLOBALS['dbUser'], $GLOBALS['dbPass'], $GLOBALS['dbName']);
    return $connection;
}

function executeQuery($query=''){
    $con = getConnection();
    $res = $con->query($query);
    if (!$res) {
    	echo $con->errno."---".$con->error;
    }
    return $res;
}

?>