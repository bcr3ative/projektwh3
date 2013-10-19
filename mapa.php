<?php
include_once 'config.php';

echo "lat	lon	title	description	icon	iconSize	iconOffset\n";
echo "\n";

db_connect();
$res=mysqli_query($mysqli,"SELECT vrijeme,event.id,event.lat,event.lon,event.naziv,event.opis,tip.ime as tim, korisnik.nadimak as at, autor,event.id_kategorija, kategorija.id from event INNER JOIN kategorija on id_kategorija=kategorija.id INNER JOIN korisnik on autor=korisnik.id INNER JOIN tip on event.id_tip=tip.id;");
while($row=$res->fetch_array()) {
	$id=$row['id'];
	$lat=$row['lat'];
	$lon=$row['lon'];
	$naziv=$row['naziv'];
	$opis=$row['opis'];
	$tip=$row['tim'];
	$autor=$row['at'];
	$vrijeme=$row['vrijeme'];
	echo "$lat	$lon	<a href='event.php?e=$id'>$naziv</a>	$vrijeme<br/>by $autor	/ikone/birthday.png	50,50	-25,-25";
	echo "\n";
}
db_disconnect();