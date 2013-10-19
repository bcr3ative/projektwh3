<?php
include_once 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Event</title>
  </head>
<body>
	<?php
	db_connect();
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		$event=$_GET['e'];
		$about=mysqli_query($mysqli, "SELECT naziv, opis, vrijeme FROM event where id=$event");
		while($row = $about->fetch_array()){ 
			echo"$row[naziv]<br>";
			echo"$row[opis]<br>";
			echo"$row[vrijeme]<br>";
		}
	}
	db_disconnect();
?>
</body>
</html>
