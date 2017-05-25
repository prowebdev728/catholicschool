<?php

include 'db_functions.php';

//receiving the parameters by query string

$proc = $_REQUEST['proc'];

if ($proc === 'addStudent') {
	$data = array();
	$data['email'] = $_POST['email'];
	$data['first_name'] = $_POST['studentFirstName'];
	$data['mi'] = $_POST['studentMI'];
	$data['last_name'] = $_POST['studentLastName'];
	$data['grade'] = $_POST['studentGrade'];
	$data['date_birth'] = $_POST['studentDateBirth'];

	$status = insertStudent($data);
	echo $status;
} else if ($proc === 'removeStudent') {
	$data = array();
	$id = $_POST['studentId'];
	
	$status = removeStudent($id);
	echo $status;
} else if ($proc === 'deleteStudent') {
	$data = array();
	$id = $_POST['studentId'];
	
	$status = removeStudent($id);
	echo $status;
}


?>
