<?php
	session_start();

	if (isset($_SESSION['user'])&&isset($_SESSION['nickname'])) {
		session_unset();
		session_destroy();
		$_SESSION = array();
	}
	
	header('Location: index.php');
?>