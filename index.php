<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
		// Registracija
	if(!empty($_POST['nickname']) && !empty($_POST['emailreg']) && !empty($_POST['passwordreg'])) {
		db_connect();

		$nickname=mysqli_real_escape_string($mysqli, $_POST['nickname']);
		$email=mysqli_real_escape_string($mysqli, $_POST['emailreg']);
		$password=mysqli_real_escape_string($mysqli, $_POST['passwordreg']);

		$query=mysqli_query($mysqli, "SELECT id FROM korisnik WHERE mail = '$email';");
		if (mysqli_num_rows($query)==0) {
			mysqli_query($mysqli, "INSERT INTO korisnik (nadimak, mail, lozinka) VALUES ('$nickname', '$email', md5('$password'));");
		}					
		db_disconnect();		
		// Login		
	} elseif (!empty($_POST['email']) && !empty($_POST['password'])) {
		db_connect();

		$email=mysqli_real_escape_string($mysqli, $_POST['email']);
		$password=mysqli_real_escape_string($mysqli, $_POST['password']);

		$query=mysqli_query($mysqli, "SELECT * FROM korisnik WHERE mail = '$email' AND lozinka = md5('$password');");
		if (mysqli_num_rows($query)==1) {
			$data=mysqli_fetch_array($query);
			$_SESSION['user']=$email;
			$_SESSION['nickname']=$data['nadimak'];
		}
		db_disconnect();
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
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
  </head>

  <body onload="init();">

  	<?php include_once 'menu.php'; ?>
  	<div style="width:100%; height:500px" id="mapdiv"></div>
  	<!-- Main jumbotron for a primary marketing message or call to action -->
  	<div class="jumbotron">
  		<div class="container">
  			<div class="col-lg-8">
  				<h1><?php echo $site_name; ?></h1>
  				<p><?php 
  					db_connect();
  					$query=mysqli_query($mysqli, "SELECT COUNT(*) FROM korisnik;");
  					db_disconnect();
  					$data=mysqli_fetch_array($query);
  					echo $data[0];
  				?> registriranih korisnika.</p>
  				<p>Nađi evente u tvojoj okolici. Posjeti ih. Nauči nešto novo. Zabavi se. <?php echo $site_name; ?> ti omogućuje pretragu za eventima bilo gdje pa i u tvojoj blizini. Izradi svoje evente i upoznaj druge korisnike. Sve to preko tvog smartphonea!</p>
  			</div>
  			<div class="col-lg-4">
  				<h2>Registracija</h2>
  				<form class="form-horizontal" role="form" action="index.php" method="POST">
  					<div class="form-group">
  						<div class="col-lg-12">
  							<input type="text" class="form-control" placeholder="Nadimak" class="form-control" name="nickname">
  						</div>
  					</div>
  					<div class="form-group">
  						<div class="col-lg-12">
  							<input type="email" class="form-control" id="inputEmail1" placeholder="Email" name="emailreg">
  						</div>
  					</div>
  					<div class="form-group">
  						<div class="col-lg-12">
  							<input type="password" class="form-control" id="inputPassword1" placeholder="Lozinka" name="passwordreg">
  						</div>
  					</div>
  					<div class="form-group">
  						<div class="col-lg-12">
  							<button type="submit" class="btn btn-default">Sign up</button>
  						</div>
  					</div>
  				</form>
  			</div>
  		</div>
  	</div>

  	<script src="http://openlayers.org/api/OpenLayers.js"></script>
  	<script>
  	map = new OpenLayers.Map("mapdiv");
  	map.addLayer(new OpenLayers.Layer.OSM());

  	var lonLat = new OpenLayers.LonLat( 14.55, 45.25 )
  	.transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
            );

  	var zoom=10;
  	var pois = new OpenLayers.Layer.Text( "Eventi",
  		{ location:"./mapa.php",
  		projection: map.displayProjection
  	});
  	map.addLayer(pois);

  	map.setCenter (lonLat, zoom);
  	</script>
  	<div class="container">
  	<hr>
  	<footer>
  		<p>&copy; <?php echo $site_name; ?> 2013</p>
  	</footer>
  	</div>
  </body>
  </html>
