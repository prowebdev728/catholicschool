<?php

include 'db_functions.php';

//receiving the parameters by query string

$studentFirstName = ($_GET['studentFirstName']);
$studentMI = ($_GET['studentMI']);
$studentLastname = ($_GET['studentLastname']);
$studentEucharist = ($_GET['studentEucharist']);
$studentPenance = ($_GET['studentPenance']);
$studentPenance = ($_GET['studentPenance']);
$studentConfirmation = ($_GET['studentConfirmation']);
$studentGrade = ($_GET['studentGrade']);
$studentDateBirth = ($_GET['studentDateBirth']);
$email = ($_GET['email']);

$resultInsertStudent = FALSE;
$resultInsertStudent = insertStudent($conn, $email, $studentFirstName, $studentMI, $studentLastname, $studentEucharist, $studentPenance, $studentConfirmation, $studentGrade, $studentDateBirth);

//Checking the results
if ($resultInsertStudent === TRUE) {
    echo "Record inserted successfully";
} else {
    echo "Error inserting record: ";
}

?>
