<?php
	include_once 'config.php';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_SESSION['user']) && isset($_SESSION['nickname'])) {
			if (!isset($_POST['event']) || !isset($_POST['lon']) || !isset($_POST['lat']) || !isset($_POST['datepicker']) || !isset($_POST['category']) || !isset($_POST['type'])) {
			} else {
				$event=$_POST['event'];
				$opis=$_POST['opis'];
				$lon=$_POST['lon'];
				$lat=$_POST['lat'];
				$numdays=$_POST['numdays'];
				$date=$_POST['datepicker'];
				$category=$_POST['category'];
				$type=$_POST['type'];

				db_connect();
				$user=$_SESSION['user'];
				$result=mysqli_query($mysqli, "SELECT id FROM korisnik WHERE mail = '$user';");
				$data=mysqli_fetch_array($result);
				$autor=$data['id'];

				if(!isset($numdays)) {
					$numdays=0;
				}			
				mysqli_query($mysqli, "INSERT INTO event (naziv, opis, lon, lat, broj_dana, vrijeme, autor, id_kategorija, id_tip) VALUES ('$event', '$opis', '$lon', '$lat', '$numdays', from_unixtime($datum1), '$autor', '$category', '$type');");
				$id=mysqli_insert_id($mysqli);
				db_disconnect();
			}
			
		}
	}	
?>

<!DOCTYPE html> 
<html>
<head>
	<title>Dodavanje evenata</title>
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script>
		$(function() {
			$('#numdays').hide();
			$("#datepicker").datepicker();
			$('#multiday').change(function() {
			  if ($(this).prop('checked')) {
			    $('#numdays').show();
			  } else {
			    $('#numdays').hide();
			  }
			});
			$('#category').change(function() {
			  $('#type').append($('#type').load('get_cat.php?category='+$('#category').val()));
			});
		});
	</script>
</head>
<body>
	<form action="add_event.php" method="POST">
		<input type="text" name="event" placeholder="Naziv"><br>
		<input type="text" name="opis" placeholder="Opis"><br>
		<input type="text" name="lon" placeholder="Širina"><br>
		<input type="text" name="lat" placeholder="Dužina"><br>
		Višednevno: <input type="checkbox" id="multiday"><br>
		<input type="text" id="numdays" name="numdays" placeholder="Broj dana"><br>
		<p>Datum: <input type="text" id="datepicker" name="datepicker"/></p>
		Kategorija: 
		<select name="category" id="category">
			<option value="default" disabled="disabled" selected="selected">Odaberi</option>
			<?php
			    db_connect();
				 if ($pretraga = $mysqli->query("SELECT id, ime FROM kategorija;")) { 
        		 	while($row = $pretraga->fetch_array()){ 
            			echo '<option value="'.$row['id'].'">'.$row['ime'].'</option>';
        			} 
   				}
    			db_disconnect();
			?>
		</select><br>
		Tip: 
		<span id="type"></span><br>
		<input type="submit" name="submit" value="Dodaj event">
	</form>
</body>
</html>