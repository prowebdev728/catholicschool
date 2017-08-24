<?php

// get row from account table
function loginCheck($email, $password) {
	require("db_connection.php");

  $sql = "SELECT * FROM account WHERE Email_Address_Id='$email' AND Password='$password' ";
  $result = $conn->query($sql);
  $num_rows = $result->num_rows;

  mysqli_free_result($result);
  $conn->close();

  return $num_rows;
}

// insert row to account table
function signup($email, $password) {
	require("db_connection.php");

	$data = array();
	$data['double'] = false;
	$data['status'] = false;

  $sql = "SELECT * FROM account WHERE Email_Address_Id='$email' ";
  $result = $conn->query($sql);

  if ($result->num_rows) {
  	$data['double'] = true;
  } else {
  	$sql = "INSERT INTO account SET Email_Address_Id='$email', Password='$password' ";
  	$data['status'] = $conn->query($sql);
  }

  mysqli_free_result($result);
  $conn->close();
  
  return $data;
}

?>