<?php
	include_once 'config.php';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$event=$_POST['event'];
		$opis=$_POST['opis'];
		$lon=$_POST['lon'];
		$lat=$_POST['lat'];
		$numdays=$_POST['numdays'];
		$days=$_POST['days'];
		$date=$_POST['datepicker'];

		if (isset($_SESSION['user'])) {
			db_connect();
			$user=$_SESSION['user'];
			$result=mysqli_query($mysqli, "SELECT id FROM korisnik WHERE mail = '$user';");
			$data=mysqli_fetch_array($result);
			$autor=$data['id'];

			if(empty($_POST['event']) || empty($_POST['lon']) || empty($_POST['lat']) || empty($_POST['numdays']) || empty($_POST['days'])) {

			}
			else {
				if(empty($_POST['days'])) {
					$numdays=0;
				}
					mysqli_query($mysqli, "INSERT INTO `event` (`event`, `opis`, `lon`, `lat`, `numdays`, `vrijeme`, `autor`) 
						VALUES ('$event', '$opis', '$lon', '$lat', '$numdays', '$date', '$autor');");
					$id=mysqli_insert_id($mysqli);
				
			}
		}
	}	
	db_disconnect();

?>

<!DOCTYPE html> 
<html>
<head>
	<title>Dodavanje evenata</title>
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script>
		$(function() {
		$( "#datepicker" ).datepicker();
		});
	</script>
</head>
<body>
	<form action="index.php" method="POST">
		<input type="text" name="event" placeholder="Naziv"><br>
		<input type="text" name="opis" placeholder="Opis"><br>
		<input type="text" name="lon" placeholder="Širina"><br>
		<input type="text" name="lat" placeholder="Dužina"><br>
		<input type="checkbox" name="days"><br>
		<input type="text" name="numdays" placeholder="Broj dana"><br>
		<input type="submit" name="submit" value="Upisi event">
		<p>Date: <input type="text" id="datepicker" /></p>
	</form>
</body>
</html>