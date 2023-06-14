<?php

$server = 'localhost';
$username = 'root';
$password = 'root';
$database = 'catdb';

// database connection code
// a port is a must. iis works on different port then MySQL. altho i donk know if its right. 
$con = new mysqli($server, $username, $password, $database, 8080) ;

// lines 16-18 are from a tutorial. thought might use it.
if ($con->connect_error) {
	die("Connection failed: " . $conn->connect_error);
  }

  ?>