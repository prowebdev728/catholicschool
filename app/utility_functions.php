<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function filter_validate_phone_number($phone_number) {
	// ex: 123-123-1234
	return preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone_number);
}

?>