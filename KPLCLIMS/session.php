<?php
	require_once "config.php";
	session_start(); 
	
	if (!isset($_SESSION['admin_id'])) {
		header('Location: ../index');
	}
?>