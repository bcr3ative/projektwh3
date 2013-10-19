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
					
					if (!empty($_GET['category']) or !empty($_GET['date']) or !empty($_GET['event']) ) {

					if(!empty($_GET['category'])) {
						$result="select * from event where id_kategorija=$_GET[category]";
					} 
					if (!empty($_GET['date'])) {
						$datum1=strtotime("$_GET[date]");
						$datum2=strtotime("$_GET[date2]");
						$result2="select * from event where unix_timestamp(vrijeme)>=$datum1 and unix_timestamp(vrijeme)<=$datum2";

						if(isset($result)) {
							$result=$result." intersect ".$result2;
						}
						else{
							$result=$result2;
						}
					} 
					if (!empty($_GET['event'])) {
						$result3="select * from event where naziv=$_GET[event]";
						if(isset($result)) {
							$result=$result." intersect ".$result3;
						}
						else{
							$result=$result3;
						}
					}
					echo "$result";
				}
					
					
					
					
					/*while($row = $pretraga->fetch_array()){ 
		            	echo "<a href='event.php?e=$row[id]'>$row[naziv]</a><br>";
		        	} */
		         
		        
		       

		        /*if(isset($_GET['category']) and isset($_GET['event'])) {
		        	$pretraga=$mysqli->query("select * from event where id_kategorija=$_GET[category] and naziv like '%$_GET[event]%'");
					while($row = $pretraga->fetch_array()){ 
		            	echo "<a href='event.php?e=$row[id]'>$row[naziv]</a><br>";
		        	} 
		        	 db_disconnect();
		        }        */
		        	
			?>
		</body>
		</html>