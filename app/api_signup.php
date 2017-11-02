<?php

include 'model_functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$data = signup($email, $password);
$response['double'] = $data['double'];
$response['status'] = $data['status'];

if ($data['status'] === true) {
	$stmt = loginCheck($email, $password);
	if ($stmt->rowCount()) {
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$response['Account_Id'] = $rows[0]['Account_Id'];
	} else {
		$response['status'] = false;
	}
}

exit(json_encode($response));

?>