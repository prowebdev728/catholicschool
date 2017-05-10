<?php

include 'db_functions.php';

//receiving the parameters by query string

$fatherName = ($_GET['fatherName']);
$fatherFamilyName = ($_GET['fatherFamilyName']);
$fatherResidesAtHome = ($_GET['fatherResidesAtHome']);
$fatherDeceased = ($_GET['fatherDeceased']);
$motherName = ($_GET['motherName']);
$motherFamilyName = ($_GET['motherFamilyName']);
$motherResidesAtHome = ($_GET['motherResidesAtHome']);
$motherDeceased = ($_GET['motherDeceased']);
$email = ($_GET['email']);

$resultUpdateUser = FALSE;
$resultUpdateUser = updateUser($email, $fatherName, $fatherFamilyName, $motherName, $motherFamilyName, $fatherResidesAtHome, $fatherDeceased, $motherResidesAtHome, $motherDeceased);

//Checking the results
if ($resultUpdateUser === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating user record";
}

?>
