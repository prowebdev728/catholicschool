<?php

// Create connection

$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "ada";

// $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

// // Check connection

// if ($conn->connect_error) {
// 	die("Connection failed: " . $conn->connect_error);
// }

try {
	$db = new PDO("mysql:host=$db_servername;dbname=$db_name;charset=utf8mb4", $db_username, $db_password);
	// set the PDO error mode to exception
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}

?>