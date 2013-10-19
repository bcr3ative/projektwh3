<?php
/****************************
 *      
 *		Configuration
 *
 ****************************/

// MySQL info
$db_server='localhost';
$db_name='projektwh3';
$db_username='projektwh3';
$db_password='projektwh3';

// Session
session_start();

// Site info
$site_name='KamoKuda';

// Setting UTF-8 encoding
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');
if (!headers_sent()) {
	header('Content-Type: text/html; charset=utf-8');
}

// Database connect
function db_connect() {
	global $db_server, $db_name, $db_username, $db_password, $mysqli;
	$mysqli=mysqli_connect("$db_server", "$db_username", "$db_password", "$db_name");
	mysqli_set_charset($mysqli,'utf8');

	if (mysqli_connect_errno()) {
		die("Failed to connect to MySQL: " .mysqli_connect_errno());
	}
}

// Database disconnect
function db_disconnect() {
	global $mysqli;
	mysqli_close($mysqli);
}