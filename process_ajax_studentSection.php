<?php

include 'db_functions.php';

//receiving the parameters by query string

$email = ($_GET['email']);

$result = FALSE;
$result = selectStudents($conn, $email);

//Checking the results
if ($result === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: ";
}

?>
