			<?php
				include_once 'config.php';
			?>

			<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Unknown" >
	<!-- <link rel="shortcut icon" href="../../assets/ico/favicon.png"> -->

	<title><?php echo $site_name; ?> | Pretraga</title>

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
					$( "#datepicker" ).datepicker();
					$( "#datepicker2" ).datepicker();
					});
				</script>
			</head>
			<body onload="init();">
				<?php include_once 'menu.php'; ?>
				<div class="container">
					<form class="form-horizontal margin-top" role="form" action="search.php" method="GET">
						<div class="form-group">
							<label for="inputName1" class="col-lg-offset-2 col-lg-2 control-label">Pocetak</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" placeholder="Naziv" name="date" id="datepicker">
							</div>
						</div>
						<div class="form-group">
							<label for="inputDesc1" class="col-lg-offset-2 col-lg-2 control-label">Kraj</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" placeholder="Opis" name="date2" id="datepicker2">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail1" class="col-lg-offset-2 col-lg-2 control-label">Kategorija</label>
							<div class="col-lg-4">
								<select class="form-control" name="category" id="category">
									<option value="default" disabled="disabled" selected="selected">Select</option>
								<?php
								    db_connect();
									//$pretraga=mysqli_query($mysqli, "select id, naziv from kategorija");
									 if ($pretraga = $mysqli->query("select id, ime from kategorija")) { 
					        		 	while($row = $pretraga->fetch_array()){ 
					            			echo '<option value="'.$row['id'].'">'.$row['ime'].'</option>';
					        			} 
					   				}
					    			db_disconnect();
								?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail1" class="col-lg-offset-2 col-lg-2 control-label">Naziv</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" name="event" placeholder="Naziv">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-4 col-lg-8">
								<button type="submit" name="search" class="btn btn-default">Prikazi evente</button>
							</div>
						</div>
					</form>
				</div>
				<?php
						
					if (!empty($_GET['category']) or !empty($_GET['date']) or !empty($_GET['event']) ) {
						if(!empty($_GET['event'])) {
							$result="select * from event where naziv like '%$_GET[event]%'";
						}

						if(!empty($_GET['category'])) {
							$result="select * from event where id_kategorija=$_GET[category]";
							if (!empty($_GET['event'])) {
								$result="select * from event where id_kategorija=$_GET[category] and naziv like '%$_GET[event]%' ";
							}
						} 

						if (!empty($_GET['date'])) {
							$datum1=strtotime("$_GET[date]");
							$datum2=strtotime("$_GET[date2]");
							$result="select * from event where unix_timestamp(vrijeme)>=$datum1 and unix_timestamp(vrijeme)<=$datum2";
							if(!empty($_GET['category'])) {
								$result="select * from event where unix_timestamp(vrijeme)>=$datum1 and unix_timestamp(vrijeme)<=$datum2 and id_kategorija=$_GET[category] ";
							}
							if(!empty($_GET['event'])) {
								$result="select * from event where unix_timestamp(vrijeme)>=$datum1 and unix_timestamp(vrijeme)<=$datum2 and naziv like '%$_GET[event]%' ";
							}
							
						} 
						if (!empty($_GET['event']) and !empty($_GET['date']) and !empty($_GET['category']) ) {
							$result="select * from event where unix_timestamp(vrijeme)>=$datum1 and unix_timestamp(vrijeme)<=$datum2 and naziv like '%$_GET[event]%' and id_kategorija=$_GET[category] ";
						}
						db_connect();

						$pretraga=mysqli_query($mysqli, $result);

						db_disconnect();
						while($row = $pretraga->fetch_array()){ 
			            	echo "<a href='event.php?e=$row[id]'>$row[naziv]</a><br>";
			            }
	
					}
						
						
				?>
			</body>
			</html>