<?php

// get row from account table
function getContactPerson($email) {
	require("db_connection.php");

	$sql = "SELECT * FROM contactperson WHERE Email1='$email' ";
	$result = $conn->query($sql);
	$rows = $result->fetch_all(MYSQLI_ASSOC);

	mysqli_free_result($result);
	$conn->close();

	return $rows;
}

?>