<?php
$servername = "localhost";
$username = "root";
$passowrd = "Tedohiciu1";
$dbname = "wowboothdb";


$conn = new mysqli($servername, $username, $passowrd, $dbname);

if ($conn->connect_error) {
	die('Connect Error (' . $conn->connect_errno . ')' . $conn->connect_error);
}
?>