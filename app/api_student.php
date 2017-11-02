<?php

include 'utility_functions.php';
include 'model_functions.php';

$proc = $_REQUEST['proc'];
$status = true;
$response = array();

if ($proc == 'addStudent') {
	$data = array();
	$data['email'] = $_POST['email'];
	$data['Account_Id'] = $_POST['Account_Id'];
	$data['First_Name'] = $_POST['studentFirstName'];
	$data['Middle_Name'] = $_POST['studentMiddleName'];
	$data['Last_Name'] = $_POST['studentLastName'];
	$data['Grade_Id'] = $_POST['studentGradeId'];
	$data['Birth_Date'] = $_POST['studentBirthDate'];
	$data['DiplomaType_Id'] = $_POST['studentDiplomaTypeId'];

	$status = insertStudent($data);
} else if ($proc == 'updateStudent') {
	$data = array();
	$data['Student_Id'] = $_POST['studentId'];
	$data['First_Name'] = $_POST['studentFirstName'];
	$data['Middle_Name'] = $_POST['studentMiddleName'];
	$data['Last_Name'] = $_POST['studentLastName'];
	$data['Grade_Id'] = $_POST['studentGradeId'];
	$data['Birth_Date'] = $_POST['studentBirthDate'];
	$data['DiplomaType_Id'] = $_POST['studentDiplomaTypeId'];

	$status = updateStudent($data);
} else if ($proc == 'removeStudent') {
	$id = $_POST['studentId'];
	
	$status = removeStudent($id);
} else if ($proc == 'revertStudent') {
	$ids = $_POST['studentIds'];

	$status = revertStudent($ids);
} else if ($proc == 'deleteStudent') {
	$id = $_POST['studentId'];
	
	$status = deleteStudent($id);
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
} else if ($proc == 'diplomaType') {
	$rows = getDiplomaType();

	if (count($rows)) {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Success';
		$response['datas'] = $rows;
	} else {
		$response['statusCode'] = http_response_code();
		$response['message'] = 'Failed';
	}
} else {
	$response['statusCode'] = http_response_code();
	$response['message'] = 'This action is not registered.';
}

if ($status) {
	$response['statusCode'] = http_response_code();
	$response['message'] = 'Success';
} else {
	$response['statusCode'] = http_response_code();
	$response['message'] = 'Failed';
}
exit(json_encode($response));

?>
