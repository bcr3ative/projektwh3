<?php
	include_once 'config.php';

	if (isset($_GET['category'])) {
		$category=$_GET['category'];
	} else {
		die();
	}

	$type=Array();

	db_connect();
	$query=mysqli_query($mysqli, "SELECT id, ime FROM tip WHERE id_kategorija = '$category';");
	db_disconnect();

	echo "<select class='form-control' name='type'>";
	while ($data=mysqli_fetch_array($query)) {
		$type[$data['id']]=$data['ime'];
		echo '<option value="'.$data['id'].'">'.$data['ime'].'</option>';
	}
	echo "</select>";
?>