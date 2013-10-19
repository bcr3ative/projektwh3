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
				$date=strtotime("$date");
				mysqli_query($mysqli, "INSERT INTO event (naziv, opis, lon, lat, broj_dana, vrijeme, autor, id_kategorija, id_tip) VALUES ('$event', '$opis', '$lon', '$lat', '$numdays', from_unixtime($date), '$autor', '$category', '$type');");
				$id=mysqli_insert_id($mysqli);
				db_disconnect();
			}
			
		}
	}	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Unknown" >
	<!-- <link rel="shortcut icon" href="../../assets/ico/favicon.png"> -->

	<title><?php echo $site_name; ?></title>

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/style.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
      <![endif]-->
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script>
		$(function() {
			$('#numdays').hide();
			$('#typecat').hide();
			$("#datepicker").datepicker();
			$('#multiday').change(function() {
			  if ($(this).prop('checked')) {
			    $('#numdays').show();
			  } else {
			    $('#numdays').hide();
			  }
			});
			$('#category').change(function() {
				$('#typecat').show();
			  	$('#type').append($('#type').load('get_cat.php?category='+$('#category').val()));
			});
		});
	</script>
</head>
<body  onload="init();">
	<?php include_once 'menu.php'; ?>
	<div class="container">
		<form class="form-horizontal margin-top" role="form" action="add_event.php" method="POST">
			<div class="form-group">
				<label for="inputName1" class="col-lg-offset-2 col-lg-2 control-label">Naziv</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" id="inputName1" placeholder="Naziv" name="event">
				</div>
			</div>
			<div class="form-group">
				<label for="inputDesc1" class="col-lg-offset-2 col-lg-2 control-label">Opis</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" id="inputDesc1" placeholder="Opis" name="opis">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-offset-2 col-lg-2 control-label">Širina</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" id="inputEmail1" placeholder="Širina" name="lon">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-offset-2 col-lg-2 control-label">Dužina</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" id="inputEmail1" placeholder="Dužina" name="lat">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-4 col-lg-8">
					<div class="checkbox">
						<label>
							<input type="checkbox" id="multiday"> Višednevno
						</label>
					</div>
				</div>
			</div>
			<div class="form-group" id="numdays">
				<label for="inputEmail1" class="col-lg-offset-2 col-lg-2 control-label">Trajanje</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" id="inputEmail1" placeholder="Broj dana" name="numdays">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-offset-2 col-lg-2 control-label">Kategorija</label>
				<div class="col-lg-4">
					<select class="form-control" name="category" id="category">
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
					</select>
				</div>
			</div>
			<div class="form-group" id="typecat">
				<label for="inputEmail1" class="col-lg-offset-2 col-lg-2 control-label">Tip</label>
				<div class="col-lg-4" id="type">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-offset-2 col-lg-2 control-label">Datum</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" id="datepicker" placeholder="Broj dana" name="datepicker">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-4 col-lg-8">
					<button type="submit" name="submit" class="btn btn-default">Dodaj event</button>
				</div>
			</div>
		</form>
	</div>
</body>
</html>