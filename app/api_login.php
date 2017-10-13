<?php

include 'model_functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = loginCheck($email, $password);

if ($stmt->rowCount()) {
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$response['statusCode'] = http_response_code();
	$response['message'] = 'Success';
	$response['Account_Id'] = $rows[0]['Account_Id'];
} else {
	$response['statusCode'] = http_response_code();
	$response['message'] = 'Failed';
}
exit(json_encode($response));

?>