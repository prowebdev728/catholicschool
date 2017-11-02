<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	$response['statusCode'] = http_response_code();
	$response['message'] = 'Invalid Request Method';
	exit(json_encode($response));
}

include 'utility_functions.php';

$data = array();
$data['Email1'] = test_input($_POST['Email1']);
$data['First_Name'] = test_input($_POST['First_Name']);
$data['Last_Name'] = test_input($_POST['Last_Name']);
$data['Address_1'] = test_input($_POST['Address_1']);
$data['Address_2'] = test_input($_POST['Address_2']);
$data['City'] = test_input($_POST['City']);
$data['State'] = test_input($_POST['State']);
$data['Zip'] = test_input($_POST['Zip']);
$data['Country'] = test_input($_POST['Country']);
$data['Phone1'] = test_input($_POST['Phone1']);
$data['Phone2'] = test_input($_POST['Phone2']);
$data['Email2'] = test_input($_POST['Email2']);

include 'model_functions.php';

setHousehold($data);

$response['statusCode'] = http_response_code();
$response['message'] = 'Success';
exit(json_encode($response));

?>