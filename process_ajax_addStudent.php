<?php

include 'db_functions.php';

//receiving the parameters by query string
$data = array();
$data['email'] = $_POST['email'];
$data['first_name'] = $_POST['studentFirstName'];
$data['mi'] = $_POST['studentMI'];
$data['last_name'] = $_POST['studentLastName'];
$data['grade'] = $_POST['studentGrade'];
$data['date_birth'] = $_POST['studentDateBirth'];

$resultInsertStudent = false;
$resultInsertStudent = insertStudent($data);

//Checking the results
if ($resultInsertStudent === true) {
   echo "Record inserted successfully";
} else {
   echo "Error inserting record: ";
}

?>
