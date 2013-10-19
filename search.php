<?php
	include_once 'config.php';
	
?>

<!DOCTYPE html> 
<html>
<head>
	<title>Pretraga evenata</title>
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script>
		$(function() {
		$( "#datepicker" ).datepicker();
		$( "#datepicker2" ).datepicker();
		});
	</script>
</head>
<body>
	<form action="search.php" method="GET">
		<p>Pocetak: <input type="text" name="date" id="datepicker" /></p>
		<p>Kraj: <input type="text" name="date2" id="datepicker2" /></p>
		Kategorija: <select class="form-control" name="category">
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
			?></select><br>
		<input type="text" name="event" placeholder="Naziv"><br>
		<input type="submit" name="search" value="Prikazi evente">
	</form>
	<?php
		if(isset($_GET['category']) and isset($_GET['date'])) {
			 db_connect();
			// echo "select * from event where id_kategorija=$_GET[category]";
			$pretraga=$mysqli->query("select * from event where id_kategorija=$_GET[category] and timestamp(vrijeme)>=$_GET[date] and timestamp(vrijeme)<=$_GET[date2]");
			while($row = $pretraga->fetch_array()){ 
            	echo "$row[naziv]";
        	} 
        }
       

        if(isset($_GET['category']) and isset($_GET['event'])) {
        	$pretraga=$mysqli->query("select * from event where id_kategorija=$_GET[category] and naziv like '%$_GET[event]%'");
			while($row = $pretraga->fetch_array()){ 
            	echo "$row[naziv]<br>";
        	} 
        	 db_disconnect();
        }        
        	
	?>
</body>
</html>