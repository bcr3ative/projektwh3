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

  	<!-- Main jumbotron for a primary marketing message or call to action -->
  	<div class="jumbotron">
  		<div class="container">
  			<div class="col-lg-8">
  				<h1>Hello, world!</h1>
	  			<p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
	  			<p><a class="btn btn-primary btn-lg">Learn more &raquo;</a></p>
  			</div>
  			<div class="col-lg-4">
  				<form class="form-horizontal" role="form" action="index.php" method="POST">
  					<div class="form-group">
  						<div class="col-lg-8">
  							<input type="text" class="form-control" placeholder="Nadimak" class="form-control" name="nickname">
  						</div>
  					</div>
  					<div class="form-group">
  						<div class="col-lg-8">
  							<input type="email" class="form-control" id="inputEmail1" placeholder="Email" name="emailreg">
  						</div>
  					</div>
  					<div class="form-group">
  						<div class="col-lg-8">
  							<input type="password" class="form-control" id="inputPassword1" placeholder="Lozinka" name="passwordreg">
  						</div>
  					</div>
  					<div class="form-group">
  						<div class="col-lg-4">
  							<button type="submit" class="btn btn-default">Sign up</button>
  						</div>
  					</div>
  				</form>
  			</div>
  		</div>
  	</div>

  	<div class="container">
<div style="width:100%; height:600px" id="mapdiv">
</div>
<script src="http://openlayers.org/api/OpenLayers.js"></script>
<script>
    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());
 
    var lonLat = new OpenLayers.LonLat( 14.1, 45.9 )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
 
    var zoom=11;
        var pois = new OpenLayers.Layer.Text( "Eventi",
                    { location:"./mapa.php",
                      projection: map.displayProjection
                    });
    map.addLayer(pois);
 
    map.setCenter (lonLat, zoom);
  </script>
  		<hr>

  		<footer>
  			<p>&copy; <?php echo $site_name; ?> 2013</p>
  		</footer>
  	</div> <!-- /container -->
  </body>
  </html>
