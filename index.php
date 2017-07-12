<?php 

session_start();
if (!isset($_SESSION['sessionId'])) {
	header('Location: php/login.php');
} else {
	header('Location: php/dashboard.php');
}

?>