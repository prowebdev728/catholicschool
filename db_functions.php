<?php

// Get an user record from user table by email

function getUser($email) {

  require("db_connection.php");

  $sql = "SELECT * FROM `user` WHERE `email` = '$email' ";
  $result = $conn->query($sql);
  $conn->close();
  return $result;
}

// Update the user table

function updateUser($email, $fatherName, $fatherFamilyName, $motherName, $motherFamilyName, $fatherResidesAtHome, $fatherDeceased, $motherResidesAtHome, $motherDeceased) {

  require("db_connection.php");

  $sql=("UPDATE user
          SET 
            father_name = $fatherName, 
            father_family_name = $fatherFamilyName, 
            mother_name = $motherName,
            mother_family_name = $motherFamilyName,
            father_resides_at_home = $fatherResidesAtHome,
            father_deceased = $fatherDeceased,
            mother_resides_at_home = $motherResidesAtHome,
            mother_deceased = $motherDeceased
          WHERE email = $email");

  //Checking the results
  if ($conn->query($sql) === TRUE) {
      return true;
  } else {
      echo "Error updating record: " . $conn->error;
      return false;
  }

}

// Insert the user table

function insertUser($email, $fatherName, $fatherFamilyName, $motherName, $motherFamilyName, $fatherResidesAtHome, $fatherDeceased, $motherResidesAtHome, $motherDeceased) {

  require("db_connection.php");

  $sql= "INSERT INTO user ( 
            email, 
            father_name, 
            father_family_name, 
            mother_name, 
            mother_family_name, 
            father_resides_at_home, 
            father_deceased, 
            mother_resides_at_home, 
            mother_deceased
            ) 
          VALUES (
            '$email', 
            '$fatherName', 
            '$fatherFamilyName', 
            '$motherName', 
            '$motherFamilyName', 
            $fatherResidesAtHome, 
            $fatherDeceased, 
            $motherResidesAtHome, 
            $motherDeceased
            )";

  //Checking the results
  if ($conn->query($sql) === TRUE) {
    return true;
  } else {
    echo "Error inserting record: " . $conn->error;
    return false;
  }
}

// Get one or more student record from student table by email

function getStudent($email) {

  require("db_connection.php");

  $sql = "SELECT * FROM student WHERE email = '$email'";

  $result = $conn->query($sql);
  $conn->close();
  return $result;
}


// Insert student

function insertStudent($conn, $email, $studentFirstName, $studentMI, $studentLastname, $studentEucharist, $studentPenance, $studentConfirmation, $studentGrade, $studentDateBirth) {

  require("db_connection.php");

  $sql= "INSERT INTO student ( 
            email, 
            first_name, 
            mi, 
            last_name, 
            eucharist, 
            penance, 
            confirmation, 
            grade, 
            date_birth
            ) 
          VALUES (
            '$email', 
            '$studentFirstName', 
            '$studentMI', 
            '$studentLastname', 
            $studentEucharist, 
            $studentPenance, 
            $studentConfirmation, 
            '$studentGrade', 
            $studentDateBirth
            )";

            //echo $sql;

  //Checking the results
  if ($conn->query($sql) === TRUE) {
    return true;
  } else {
    echo "Error inserting record: " . $conn->error;
    return false;
  }
}

?>