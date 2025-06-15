<?php

$servername = "MySQL-8.0";
$username = "root";
$passworD = "";
$dbname = "accaunts";

$conn = new mysqli($servername, $username, $passworD, $dbname);

if (!$conn) {
	die("Connection fialed" . $conn->mysqli_connect_error);
}
