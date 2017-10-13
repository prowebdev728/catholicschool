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

// validation
$errMsg = '';

if (empty($data['First_Name'])) {
  $errMsg = 'First Name is required';
} else if (empty($data['Last_Name'])) {
  $errMsg = 'Last Name is required';
} else if (empty($data['Address_1'])) {
  $errMsg = 'Home Address is required';
} else if (empty($data['City'])) {
  $errMsg = 'City is required';
} else if (empty($data['State'])) {
  $errMsg = 'State is required';
} else if (empty($data['Zip'])) {
  $errMsg = 'Zip Code is required';
} else if (empty($data['Country'])) {
  $errMsg = 'Country is required';
} else if (empty($data['Phone1'])) {
  $errMsg = 'Phone Number is required';
} else if (!filter_validate_phone_number($data['Phone1'])) {
  $errMsg = 'Invalid Phone Number format'; 
} else if (!empty($data['Phone2']) && !filter_validate_phone_number($data['Phone2'])) {
  $errMsg = 'Invalid Alternate Phone Number format'; 
} else if (!empty($data['Email2']) && !filter_var($data['Email2'], FILTER_VALIDATE_EMAIL)) {
  $errMsg = 'Invalid email format'; 
}

if ($errMsg) {
	$response['statusCode'] = http_response_code();
	$response['message'] = $errMsg ? $errMsg : 'Success';
	exit(json_encode($response));
}

include 'model_functions.php';

setHousehold($data);

$response['statusCode'] = http_response_code();
$response['message'] = 'Success';
exit(json_encode($response));

?>