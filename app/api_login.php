<?php

include 'api_model_functions.php';

$email = $_GET['email'];
$password = $_GET['password'];

$result = loginCheck($email, $password);

$response['status'] = $result ? true : false;

echo json_encode($response);

?>