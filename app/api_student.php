<?php

include 'utility_functions.php';
include 'model_functions.php';

//receiving the parameters by query string

$proc = $_REQUEST['proc'];

if ($proc == 'addStudent') {
	$data = array();
	$data['email'] = $_POST['email'];
	$data['Account_Id'] = $_POST['Account_Id'];
	$data['First_Name'] = $_POST['studentFirstName'];
	$data['Middle_Name'] = $_POST['studentMiddleName'];
	$data['Last_Name'] = $_POST['studentLastName'];
	$data['Grade_Id'] = $_POST['studentGradeId'];
	$data['Birth_Date'] = $_POST['studentBirthDate'];

	$status = insertStudent($data);
	if ($status) {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Success';
	} else {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Failed';
	}
	exit(json_encode($response));
} else if ($proc == 'updateStudent') {
	$data = array();
	$data['Student_Id'] = $_POST['studentId'];
	$data['First_Name'] = $_POST['studentFirstName'];
	$data['Middle_Name'] = $_POST['studentMiddleName'];
	$data['Last_Name'] = $_POST['studentLastName'];
	$data['Grade_Id'] = $_POST['studentGrade'];
	$data['Birth_Date'] = $_POST['studentDateBirth'];

	$status = updateStudent($data);
	if ($status) {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Success';
	} else {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Failed';
	}
	exit(json_encode($response));
} else if ($proc == 'removeStudent') {
	$id = $_POST['studentId'];
	
	$status = removeStudent($id);
	if ($status) {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Success';
	} else {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Failed';
	}
	exit(json_encode($response));
} else if ($proc == 'revertStudent') {
	$ids = $_POST['studentIds'];

	$status = revertStudent($ids);
	if ($status) {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Success';
	} else {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Failed';
	}
	exit(json_encode($response));
} else if ($proc == 'deleteStudent') {
	$id = $_POST['studentId'];
	
	$status = deleteStudent($id);
	if ($status) {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Success';
	} else {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Failed';
	}
	exit(json_encode($response));
} else if ($proc == 'getNotEnrolledStudent') {
	$email = $_POST['email'];

	$stmt = getStudent($email, false);
	if ($stmt->rowCount()) {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Success';
		$response['datas'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} else {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Failed';
	}
	exit(json_encode($response));
}


?>
