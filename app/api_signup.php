<?php

include 'api_model_functions.php';

$email = $_GET['email'];
$password = $_GET['password'];

$response = signup($email, $password);

echo json_encode($response);

?>