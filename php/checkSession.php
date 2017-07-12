<?php 

session_start();
if (!isset($_SESSION['sessionId'])) {
	header('Location: ../php/login.php');
}

?>