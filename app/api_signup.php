<?php

include 'model_functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$response = signup($email, $password);

echo json_encode($response);

?>